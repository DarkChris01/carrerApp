<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Candidacy;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $candidatures =  Candidacy::join("jobs", "jobs.id", "candidacies.job_id")
            ->join("employers", "employers.id", "jobs.employer_id")
            ->join("cvs", "cvs.id", "candidacies.cv_id")
            ->where("employers.id", $request->user("employer")->id)
            ->select("candidacies.id as candidature_id", "candidacies.*", "cvs.firstName", "cvs.profession", "cvs.picture", "jobs.poste")
            ->where("candidacies.status", "pending")
            ->get();

        return inertia("Employer/Dashboard", [
            "candidates" => $candidatures
        ]);
    }

    public function get_dashboard_data(Request $request, $year = "2025")
    {
        $jobs = $request->user('employer')
            ->jobs()
            ->whereYear("created_at", $year)
            ->get();

        $candidatures = Candidacy::join("jobs", "jobs.id", "candidacies.job_id")
            ->join("employers", "jobs.employer_id", "employers.id")
            ->where("employers.id", $request->user('employer')->id)
            ->whereYear("candidacies.created_at", $year)
            ->select(["candidacies.created_at as date_creation"])
            ->get();

        return ["jobs" => $jobs, "candidatures" => $candidatures];
    }

    public function get_open_jobs_datas(Request $request, $year = "2025")
    {
        $jobs = Job::whereDate("expired_at", ">", now())
            ->where("employer_id", $request->user("employer")->id)
            ->whereYear("created_at", $year)
            ->with("candidacies")
            ->distinct()
            ->get();

        return $jobs;
    }
}
