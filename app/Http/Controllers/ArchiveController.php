<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Archives\ArchiveCandidacy;


class ArchiveController extends Controller
{
    public function __construct(private ArchiveCandidacy $archiveService) {}

    public function store(Request $request)
    {
        $this->archiveService->archivate($request);
    }
}
