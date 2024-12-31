<?php

namespace App\Services\Archives;

use App\Models\Candidacy;
use Illuminate\Http\Request;

class ArchiveCandidacy
{
    public function get($user)
    {
        return $user->archives;
    }

    public function archivate(Request $request)
    {
        $request->validate([
            "candidacy" => ["required", "integer", "exists:candidacies,id"]
        ]);
        Candidacy::where("id", $request->candidacy)
            ->firstorfail()
            ->archives()
            ->create(["user_id" => $request->user()->id]);
    }
}
