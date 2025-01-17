<?php

namespace App\Http\Controllers;

use App\Models\Competence_job;
use App\Models\Cv;
use App\Models\User;
use App\Services\CandidacyService;
use App\Services\StringAnalyser;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CvController extends Controller
{
    public function __construct(private CandidacyService $candidacyService) {}

    public function show_information()
    {
        return inertia("Cv/Personal-Information");
    }
    public function show_formation()
    {
        return inertia("Cv/Formations");
    }
    public function show_experience()
    {
        return inertia("Cv/Experiences");
    }
    public function show_competence()
    {
        return inertia("Cv/Competences");
    }

    public function create(Request $request)
    {
        $cv = $request->user()
            ->cv()
            ->with(["experience", "competence", "formation"])
            ->first();

        return inertia("Cv/Personal-Information", ["cv" => $cv]);
    }


    public function index(Request $request)
    {
        $cvs = DB::table("cvs")
            ->leftjoin("competences", "cvs.id", "competences.cv_id")
            ->leftJoin("experiences", "cvs.id", "experiences.cv_id")
            ->when($request->domain, function ($query, $domain) {
                $query->where(function ($query) use ($domain) {
                    foreach ($domain as $value) {
                        return $query->orwhereJsonContains("competences.technical_competences", $value)
                            ->orWhereJsonContains("experience", ["poste" => $value]);
                    }
                });
            })
            ->when($request->country, function ($query, $country) {
                foreach ($country as $value) {
                    return $query->orwhere("cvs.country", "REGEXP", $value);
                }
            })

            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    return $query->where("cvs.profession", "REGEXP", $search)
                        ->orwhere("cvs.country", "REGEXP", $search);
                });
            })
            ->select(["cvs.*", "competences.technical_competences"])
            ->orderBy("cvs.updated_at")
            ->paginate(20)
            ->appends(["domain" => $request->domain]);

        return Inertia::render("Employer/Cv/index", ['datas' => $cvs]);
    }



    public function store(Request $request)
    {

        $request->validate([
            "firstName" => ["required", "string", "min:3", "max:50"],
            "lastName" => ["required", "string", "min:3", "max:50"],
            "birth_date" => ["required", "date"],
            "phone" => ["required", "string"],
            "email" => ["required", "email"],
            "country" => ["required", "string"],
            "sexe" => ["required", "string"],
            "profession" => ["required", "string"],
            "cv" => ["nullable", "sometimes", "file", "mimes:pdf", "max:2500"],
            "picture" => ["nullable", 'sometimes', "file", "mimes:png,svg,jpg", "max:600"]

        ]);

        $cv = $request->user()->cv ?? new Cv();

        $cv->firstName = $request->firstName;
        $cv->lastName = $request->lastName;
        $cv->birth_date = $request->birth_date;
        $cv->phone = $request->phone;
        $cv->email = $request->email;
        $cv->country = $request->country;
        $cv->user_id = $request->user()->id;
        $cv->sexe = $request->sexe;
        $cv->profession = $request->profession;


        if ($request->picture) {
            $path = Storage::disk('public')->put("Cv/pictures", $request->picture);
            $cv->picture = "/storage/" . $path;
        }

        if ($request->cv) {
            $cv_path = Storage::disk('local')->put("Cv/files", $request->cv);
            $cv->cv = $cv_path;
        }
      
        try {
            $cv->save();
            return to_route("formations.create");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show_cv_for_user(Request $request)
    {
        $cv = CV::where("user_id", $request->user()->id)->with(["competence", "formation", "experience", "user"])
            ->first();
        return inertia("Cv/Create", compact("cv"));
    }

    public function show_cv_for_employer(Cv $cv)
    {

        $cv = Cv::where("id", $cv->id)
            ->with(["competence", "formation", "experience", "user"])->first();

        return inertia("Employer/Cv/Show", compact("cv"));
    }


    public function get_best_profil(Request $request)
    {
        return $this->candidacyService->get_best_candidate_by_enterprise($request->user("employer")->enterprise);
    }


    public function rate(Cv $cv)
    {
        return $this->candidacyService->rate($cv);
    }

    public function get_user_cv_info(Request $request)
    {
        return $request->user()->cv;
    }
}
