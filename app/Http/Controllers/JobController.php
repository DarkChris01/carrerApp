<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Competence_job;
use App\Services\StringAnalyser;
use App\Services\NotificationService;
use App\Http\Requests\CreateJobRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewJobCreatedNotification;

class JobController extends Controller
{
    public function __construct(private NotificationService $notificationService) {}

    public function index(Request $request)
    {

        $data = $request->user("employer")->jobs()
            ->leftjoin("competence_jobs", "jobs.id", "competence_jobs.job_id")
            ->leftjoin("domains", "jobs.domain_id", "domains.id")
            ->when($request->domain, function ($query, $domain) {
                $query->where(function ($query) use ($domain) {

                    foreach ($domain as $value) {
                        $query->whereJsonContains("competence_jobs.competence", strtolower($value))
                            ->orwhere("domains.intitules", $value);
                    }
                });
            })
            ->when($request->country, function ($query, $country) {
                $query->where(function ($query) use ($country) {
                    foreach ($country as $value) {
                        $query->orwhere("jobs.country", "REGEXP", $value);
                    }
                });
            })
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where("domains.intitules", "REGEXP", $search)
                        ->orwhere("jobs.poste", "REGEXP", $search);
                });
            })
            ->with(['enterprise', 'competence', "domain", "candidacies" => function ($query) {
                return  $query->where("status", "pending");
            }])
            ->select(["jobs.*", "competence_jobs.competence"])
            ->orderby("created_at", "DESC")
            ->paginate()
            ->appends(["domain_id" => $request->domain]);


        return inertia("Jobs/index", ['data' => $data]);
    }


    public function show(Job $job, Request $request)
    {
        $data = job::where('id', $job->id)
            ->with(['competence', 'enterprise'])
            ->when($request->user(), function ($query) use ($request) {
                $query->with(["candidacies" => function ($query) use ($request) {
                    if ($request->user()->cv) {
                        return  $query->where("cv_id", $request->user()->cv->id);
                    }
                    return false;
                }]);
            })
            ->first();
        if ($request->user('employer')) {
            return inertia("Jobs/Job", ["job" => $data]);
        }
        return inertia("User/Jobs/Show", ["job" => $data]);
    }

    public function edit(Job $job)
    {
        $data = Job::where("id", $job->id)->with(["competence", "domain"])->first();

        return inertia("Jobs/Edit", ["job" => $data]);
    }

    public function create()
    {
        return inertia("Jobs/Create");
    }

    public function store(CreateJobRequest $request)
    {
        $request->authorize();

        $job = new Job();

        $job->employer_id = $request->user('employer')->id;
        $job->enterprise_id = $request->user('employer')->enterprise->id;
        $job->poste = strtoLower($request->poste);
        $job->domain_id = $request->domain;
        $job->missions = $request->mission;
        $job->country = $request->country;
        $job->expired_at = $request->delay;
        $job->type = $request->type;
        $job->salary = $request->salary;
        $job->formation = $request->formation;
        $job->experience = $request->experience;
        $job->effective = $request->effective;

        if ($job->save()) {
            $d = json_encode([
                $request->competence1,
                $request->competence2,
                $request->competence3,
                $request->competence4,
                $request->competence5,
                $request->competence6
            ]);
            Competence_job::create([
                "job_id" => $job->id,
                "competence" => $d
            ]);

            $data = Job::where('id', $job->id)
                ->with("enterprise", "competence")
                ->first();

            $this->notificationService->NotifiyUserWhenNewJobIsCreated(User::all(), $data);
            return to_route("job.show", ["job" => $data]);
        }
    }

    public function update(CreateJobRequest $request)
    {
        $other_competences = null;

        $request->authorize();

        $competences = json_encode([
            $request->competence1,
            $request->competence2,
            $request->competence3,
            $request->competence4
        ]);

        if ($request->competence5) {
            $other_competences = json_encode([
                $request->competence5,
                $request->competence6
            ]);
        }

        $job = job::where("id", $request->job)->firstorfail();

        $job->employer_id = $request->user('employer')->id;
        $job->enterprise_id = $request->user('employer')->enterprise->id;
        $job->poste = $request->poste;
        $job->domain_id = $request->domain;
        $job->missions = $request->mission;
        $job->country = $request->country;
        $job->expired_at = $request->delay;
        $job->type = $request->type;
        $job->salary = $request->salary;
        $job->formation = $request->formation;
        $job->experience = $request->experience;
        $job->effective = $request->effective;

        if ($job->save()) {

            $d = json_encode([
                $request->competence1,
                $request->competence2,
                $request->competence3,
                $request->competence4,
                $request->competence5,
                $request->competence6
            ]);
            $job->Competence->update([
                "competence" => $d
            ]);

            $data = Job::where('id', $job->id)->with("enterprise", "competence")->first();
            return to_route("job.show", ["job" => $data]);
        }
    }

    public function delete(Request $request)
    {
        $request->validate([
            "job" => ['required', "string", "exists:jobs,id"]
        ]);

        $job = Job::where("id", $request->job);
        try {
            if ($job->delete()) {
                return to_route("jobs.index");
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function retrieve_all_jobs()
    {
        return Job::where("expired_at", ">", now())->get("poste");
    }
}
