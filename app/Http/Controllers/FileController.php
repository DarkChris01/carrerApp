<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use App\Models\Candidacy;
use Dotenv\Store\File\Paths;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Exists;

class FileController extends Controller
{

    public function download_cv(Cv $cv)
    {

        if (Storage::fileExists($cv->cv)) {
            return Storage::download($cv->cv, $cv->firstName . "_cv");
        }

        return inertia("404");
    }
}
