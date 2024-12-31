<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use App\Models\Job;
use App\Models\Candidacy;
use Illuminate\Http\Request;
use App\Events\NotifyCandidate;
use App\Models\Archive;
use App\Services\StringAnalyser;
use App\Services\CandidacyService;
use App\Services\NotificationService;
use App\Notifications\ApprouvedNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CandidacyRejectedNotification;

class CandidacyController extends Controller
{
    public function __construct(private NotificationService $notificationService, private CandidacyService $candidacyService) {}


    public function get_user_candidacies(Request $request)
    {
        $archived = Archive::where("archivable_type", Candidacy::class)->get("archivable_id");

        if ($request->user()->cv) {
            return Candidacy::where("cv_id", $request->user()->cv->id)
                ->whereNotIn("id", $archived)
                ->with(["job" => function ($query) {
                    return $query->with("enterprise");
                }])
                ->get();
        }
        return [];
    }

    public function index(Request $request)
    {
       
        $jobs = $this->candidacyService->get($request->user("employer"));

        return inertia("Candidates/index", ["jobs" => $jobs]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "job" => ["required", "string", "exists:jobs,id"]
        ]);
        if (Candidacy::where("job_id", $request->job)->where("cv_id", $request->user()->cv->id)->first()) {
            return back()->withErrors("", "dejaCandidate");
        }
        try {
            $candidature = Candidacy::create([
                'job_id' => $request->job,
                "cv_id" => $request->user()->cv->id
            ]);

            $this->notificationService->NotifyEmployerWhenNewApplicationIsAdded($candidature, $request->user(), Job::find($request->job)->enterprise);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(Candidacy $candidacy)
    {
        $candidacy->delete();
    }

    public function masquer(Candidacy $candidacy)
    {
        $candidacy->update([
            "archived" => true
        ]);
    }


    public function show(Job $job, Request $request, StringAnalyser $analyser)
    {
        $j = Job::where("id", $job->id)->with(["enterprise", "competence"])->first();

        $array_of_candidates = [];

        $c = Candidacy::join("cvs", "cvs.id", "candidacies.cv_id")
            ->leftjoin("competences", "competences.cv_id", "cvs.id")
            ->join("users", "users.id", "cvs.user_id")
            ->leftjoin("entretiens", "entretiens.candidacy_id", "candidacies.id")
            ->when($request->country, function ($query) use ($request) {
                foreach ($request->country as $value) {
                    return $query->orwhere("cvs.country", "REGEXP", $value);
                }
            })
            ->select(["candidacies.id as candidature_id", "candidacies.cv_id", "competences.technical_competences", "cvs.*", "entretiens.status as entretien_status", "entretiens.id as entretien_id"])
            ->where("candidacies.job_id", $job->id)
            ->where("candidacies.status", "!=", "rejected")
            ->get();

        if ($request->domain) {
            foreach ($request->domain as $domain) {
                foreach ($c as $candidacy) {
                    foreach (json_decode($candidacy->technical_competences) as $competence) {
                        if ($competence) {
                            if ($analyser->is_correspondant($competence, $domain)) {
                                if (!in_array($candidacy, $array_of_candidates)) {
                                    $array_of_candidates = [...$array_of_candidates, $candidacy];
                                }
                            }
                        }
                    }
                }
            }
            $candidacies = $array_of_candidates;
        } else if ($request->search) {
            foreach (explode(" ", $request->search) as $search) {
                foreach ($c as $candidacy) {
                    foreach (json_decode($candidacy->technical_competences) as $competence) {
                        if ($competence) {
                            if ($analyser->is_correspondant($competence, $search)) {
                                if (!in_array($candidacy, $array_of_candidates)) {
                                    $array_of_candidates = [...$array_of_candidates, $candidacy];
                                }
                            }
                        }
                    }
                }
            }
            $candidacies = $array_of_candidates;
        } else {
            $candidacies = $c;
        }

        return inertia("Candidates/index", ["candidacies" => $candidacies, "job" => $j]);
    }

    public function approuved(Candidacy $candidacy)
    {
        $cv = Cv::where("id", $candidacy->cv_id)->firstorfail();

        Notification::send($cv, new ApprouvedNotification());
    }

    public function rejected(Candidacy $candidate, Request $request)
    {
        if ($candidate->update([
            "status" => "rejected"
        ])) {
            Notification::send($candidate->cv->user, new CandidacyRejectedNotification($candidate->job));
        }
    }
}
