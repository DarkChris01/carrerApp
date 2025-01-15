<?php

namespace App\Services;

use App\Models\Cv;
use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use App\Models\Domain;
use App\Models\Metier;
use App\Models\Employer;
use App\Models\Candidacy;
use App\Models\Enterprise;
use Illuminate\Http\Request;
use App\Services\StringAnalyser;

class CandidacyService
{
    public function __construct(private StringAnalyser $analyse, private Request $request) {}


    public  function get(Employer $employer)
    {
        $jobs = $employer->jobs ?? [];

        if ($jobs) {
            foreach ($jobs as $job) {
                return $job
                    ->when($this->request->has("active"), function ($query) {
                        $query->where("expired_at", ">", now());
                    })

                    ->when($this->request->has("expire"), function ($query) {
                        $query->where("expired_at", "<=", now());
                    })
                    ->when($this->request->has("offre"), function ($query) {
                        $query->where('id', $this->request->offre);
                    })
                    ->with(["candidacies" => function ($query) {
                        $query->when($this->request->has("rejete"), function ($query) {
                            $query->where("status", "rejected");
                        })
                            ->when($this->request->has("accepte"), function ($query) {
                                $query->where("status", "OK");
                            })->with(["cv" => function ($query) {
                                $query->with("competence");
                            }]);
                    }])
                    ->when(
                        $this->request->has("poste"),
                        function ($query) {
                            $query->where(function ($query) {
                                foreach ($this->request->poste as $value) {
                                    $query->orwhere('poste', $value);
                                };
                            });
                        }
                    )
                    ->where("employer_id", $employer->id)
                    ->get();
            }
        }
    }

    public function deleteWhereIsERejected(User $user)
    {

        $user->cv->candidacies()
            ->where("status", "rejected")
            ->where("updated_at", "<", Carbon::now()->subHours(3))
            ->delete();
    }


    public function get_best_candidate_by_enterprise(Enterprise $enterprise)
    {
        $candidates = [];

        $cvs = Cv::Join("competences", "cvs.id", "competences.cv_id")
            ->Join("experiences", "cvs.id", "experiences.cv_id")
            ->Join("formations", "cvs.id", "formations.cv_id")
            ->select(["cvs.*", "competences.technical_competences", "experiences.experience"])
            ->get();

        if ($enterprise) {
            $enterprise = $enterprise->sector;

            foreach ($cvs as $cv) {
                foreach (json_decode($cv->technical_competences) as $words) {
                    if ($words) {
                        foreach (explode(" ", $words) as $word) {
                            foreach (explode(" ", $enterprise->sector1) as $sector1) {
                                if (
                                    $this->analyse->is_correspondant($word, $sector1)
                                ) {
                                    if (!in_array($cv, $candidates)) {
                                        $candidates = [...$candidates, $cv];
                                    }
                                }
                            }
                            foreach (explode(" ", $enterprise->sector2) as $sector2) {
                                if (
                                    $this->analyse->is_correspondant($word, $sector2)
                                ) {
                                    if (!in_array($cv, $candidates)) {
                                        $candidates = [...$candidates, $cv];
                                    }
                                }
                            }
                            foreach (explode(" ", $enterprise->sector3) as $sector3) {
                                if (
                                    $this->analyse->is_correspondant($word, $sector3)
                                ) {
                                    if (!in_array($cv, $candidates)) {
                                        $candidates = [...$candidates, $cv];
                                    }
                                }
                            }
                            foreach (explode(" ", $enterprise->sector4) as $sector4) {
                                if (
                                    $this->analyse->is_correspondant($word, $sector4)
                                ) {
                                    if (!in_array($cv, $candidates)) {
                                        $candidates = [...$candidates, $cv];
                                    }
                                }
                            }
                        }
                    }
                }

                foreach (json_decode($cv->experience) as $experience) {
                    if ($experience->poste) {
                        foreach (explode(" ", $experience->poste) as $words) {
                            foreach (explode(" ", $enterprise->sector1) as $sector) {
                                if (
                                    $this->analyse->is_correspondant($experience->poste, $sector)
                                ) {
                                    if (!in_array($cv, $candidates)) {
                                        $candidates = [$cv, ...$candidates];
                                    }
                                }
                            }
                            foreach (explode(" ", $enterprise->sector2) as $sector) {
                                if (
                                    $this->analyse->is_correspondant($experience->poste, $sector)

                                ) {
                                    if (!in_array($cv, $candidates)) {
                                        $candidates = [$cv, ...$candidates];
                                    }
                                }
                            }
                            foreach (explode(" ", $enterprise->sector3) as $sector) {
                                if (
                                    $this->analyse->is_correspondant($experience->poste, $sector)

                                ) {
                                    if (!in_array($cv, $candidates)) {
                                        $candidates = [$cv, ...$candidates];
                                    }
                                }
                            }
                            foreach (explode(" ", $enterprise->sector4) as $sector) {
                                if (
                                    $this->analyse->is_correspondant($experience->poste, $sector)

                                ) {
                                    if (!in_array($cv, $candidates)) {
                                        $candidates = [$cv, ...$candidates];
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return $candidates;
        } else {
            return $candidates;
        }
        return [];
    }

    public function rate(Cv $cv)
    {
        $enterprise = $this->request->user("employer")->enterprise;
        $sectors = [
            $enterprise->sector->sector1,
            $enterprise->sector->sector2,
            $enterprise->sector->sector3,
            $enterprise->sector->sector4,
        ];
        $score = 0;
        foreach ($sectors as $words) {
            foreach (explode(" ", $words) as $word) {
                if ($cv->competence) {
                    foreach (json_decode($cv->competence->technical_competences) as $competence) {
                        if ($this->analyse->is_correspondant($word, $competence)) {
                            if ($score < 10) {
                                $score++;
                            }
                        }
                    }
                    foreach (json_decode($cv->experience->experience) as $experience) {
                        foreach (explode(" ", $experience->poste) as $poste) {
                            if ($this->analyse->is_correspondant($word, $poste)) {
                                if ($score < 10) {
                                    $score = $score + Carbon::parse($experience->start)->diffInYears(Carbon::parse($experience->end));
                                }
                            }
                        }
                    }
                }
            }
        }
        return $score;
    }
}
