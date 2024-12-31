<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{

    public function create(Request $request)
    {
        return inertia("Cv/Experiences", ["experiences" => $request->user()->cv->experience]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "enterprise" => ["required", "string", "max:100"],
            "role" => ["required", "string",  "max:100"],
            "task" => ["required", "string", "max:1000"],
            "start" => ['required', "date"],
            "end" => ["nullable", "date"],

            "enterprise2" => ["nullable", "sometimes", "required_with:role2", "string", "max:100"],
            "role2" => ["nullable", "required_with:task2,", "string", "max:100"],
            "task2" => ["nullable",  "string", "required_with:start2", "max:1000"],
            "start" => ['nullable', "date", "required_with:end2",],
            "end" => ["nullable", "date", "required_with:enterprise2",]
        ]);

        $cv = $request->user()->cv;


        $data = json_encode(
            [
                [
                    "enterprise" => $request->enterprise,
                    "poste" => strtolower($request->role),
                    "mission" => $request->task,
                    "start" => $request->start,
                    "end" => $request->end
                ],
                [
                    "enterprise" => $request->enterprise2,
                    "poste" => strtolower($request->role2),
                    "mission" => $request->task2,
                    "start" => $request->start2,
                    "end" => $request->end2,
                ],

            ]
        );
        $experiences = $cv->experience ?? new Experience();
        $experiences->experience = $data;

        try {
            $cv->experience()->save($experiences);
            return to_route("competences.create");
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
