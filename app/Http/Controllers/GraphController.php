<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Candidacy;
use Illuminate\Http\Request;

class GraphController extends Controller
{
    public function get_dashboard_data(Request $request)
    {
        $user = $request->user('employer');
        $candidatures = Candidacy::join("jobs", "jobs.id", "candidacies.job_id")
            ->join("employers", "jobs.employer_id", "employers.id")
            ->where("employers.id", $request->user('employer')->id)
            ->select(["candidacies.created_at as date_creation"])
            ->get();

        return ["jobs" => $user->jobs, "candidatures" => $candidatures];
    }

    public function get_open_jobs_datas(Request $request)
    {
        $jobs = Job::whereDate("expired_at", ">", now())
            ->where("employer_id", $request->user("employer")->id)

            ->with("candidacies")
            ->distinct()
            ->get();

        return $jobs;
    }
}
