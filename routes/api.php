<?php

use App\Models\Domain;
use App\Models\Metier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CandidacyController;
use App\Http\Controllers\Api\InterviewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/db-competences', function () {
    return response()->json(Metier::all());
});

Route::get('/db-domains', function () {
    return response()->json(Domain::all());
});

