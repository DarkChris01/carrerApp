<?php

namespace App\Http\Controllers;

use App\Models\Enterprise;
use App\Models\Job;
use Illuminate\Http\Request;

class AcceuilController extends Controller
{
    public function index(Request $request)
    {

        $jobs = Job::join("domains", "domains.id", "jobs.domain_id")
            ->with(["enterprise", "competence"])
            ->when($request->domain, function ($query, $domain) {
                $query->where("domain_id", $domain);
            })

            ->when($request->contract, function ($query, $contract) {
                $query->where("type", $contract);
            })
            ->when($request->enterprise, function ($query, $enterprise) {
                $query->where("enterprise_id", $enterprise);
            })
            ->when($request->country, function ($query, $country) {
                $query->where("country", $country);
            })

            ->when($request->search, function ($query, $search) {
                return $query->where("domains.intitules", "REGEXP", $search);
            })

            ->when($request->hasAny(["min", "max"]), function ($query) use ($request) {
                if (!$request->min) {
                    return $query->whereBetween("salary", [0, $request->max]);
                } else if (!$request->max) {
                    return $query->whereBetween("salary", [$request->min, 999999]);
                } else {

                    return $query->whereBetween("salary", [$request->min, $request->max]);
                }
            })

            ->when($request->salary, function ($query, $salary) {
                $query->where(function ($query) use ($salary) {
                    if ($salary == 50) {
                        $query->orwhere("salary", "<", 100000);
                    } else if ($salary == 100) {
                        $query->orwhere("salary", ">", 100000);
                    } else if ($salary == 200) {
                        $query->orwhere("salary", ">", 200000);
                    } else if ($salary == 300) {
                        $query->orwhere("salary", ">", 300000);
                    } else {
                        $query->orwhere("salary", ">", 300);
                    }
                });
            })
            ->latest()
            ->select(["jobs.*", "domains.intitules"])
            ->paginate()
            ->appends(["domain" => $request->domain]);

        return inertia('Acceuil', ["jobs" => $jobs, "enterprises" => Enterprise::all()]);
    }
}
