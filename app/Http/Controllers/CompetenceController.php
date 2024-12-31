<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use App\Models\Competence;

use Illuminate\Http\Request;
use function Laravel\Prompts\error;

class CompetenceController extends Controller
{
    public function create(Request $request)
    {
        return inertia("Cv/Competences", ["competences" => $request->user()->cv->competence]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "competence1" => ["required", "string"],
            "competence2" => ["nullable", "sometimes", "string"],
            "competence3" => ["nullable", "sometimes", "string"],
            "competence4" => ["nullable", "sometimes", "string"],
            "competence5" => ["nullable", "sometimes", "string"],
            "competence6" => ["nullable", "sometimes", "string"],
            "competence7" => ["nullable", "sometimes", "string"],
            "competence8" => ["nullable", "sometimes", "string"]
        ]);

        $cv = $request->user()->cv;

        $competence_technic = json_encode([
            strtolower($request->competence1),
            strtolower($request->competence2),
            strtolower($request->competence3),
            strtolower($request->competence4),
            strtolower($request->competence5)
        ]);
        $competence_notechnical = json_encode([
            strtolower($request->competence6),
            strtolower($request->competence7),
            strtolower($request->competence8),
        ]);

        $competence = $cv->competence ?? new Competence();
        $competence->technical_competences = $competence_technic;
        $competence->no_technical_competences = $competence_notechnical;

        try {
            $cv->competence()->save($competence);
            return to_route("show.cv");
        } catch (\Throwable $th) {
            return error("error occured");
        }
    }
}
