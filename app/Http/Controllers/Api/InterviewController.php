<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\EntretienService;
use Illuminate\Http\Request;

class InterviewController extends Controller
{

    public function __construct(private EntretienService $entretienService) {}


   
}
