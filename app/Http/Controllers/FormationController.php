<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{

    public function create(Request $request)
    {
        return inertia("Cv/Formations", ["formations" => $request->user()->cv->formation]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            "school" => ["required", "string", "max:100"],
            "competence" => ["required", "string"],
            "degree" => ["required", "string", "max:100"],
            "date" => ["required", "date"],

            "school2" => ["nullable", "sometimes", "required_with:competence2", "string", "max:100"],
            "competence2" => ["nullable", "sometimes", "string", "required_with:degree2"],
            "degree2" => ["nullable", "sometimes", "string", "max:100", "required_with:date2"],
            "date2" => ["nullable", "sometimes", "date", "required_with:school2"],

            "school3" => ["nullable", "sometimes", "required_with:competence3", "string", "max:100"],
            "competence3" => ["nullable", "sometimes", "string", "required_with:degree3"],
            "degree3" => ["nullable", "sometimes", "string", "max:100", "required_with:data3"],
            "date3" => ["nullable", "sometimes", "date", "required_with:school3"],
        ]);

        $cv = $request->user()->cv;

        $formations = json_encode([
            [
                "school" => $request->school,
                "domain" => strtolower($request->competence),
                "degree" => $request->degree,
                "date" => $request->date
            ],
            [
                "school" => $request->school2,
                "domain" => strtolower($request->competence2),
                "degree" => $request->degree2,
                "date" => $request->date2
            ],
            [
                "school" => $request->school3,
                "domain" => strtolower($request->competence3),
                "degree" => $request->degree3,
                "date" => $request->date3
            ]
        ]);

        $f = $cv->formation ?? new Formation();
        $f->formations = $formations;

        try {
            if ($cv->formation()->save($f)) {
                return to_route("experiences.create");
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
