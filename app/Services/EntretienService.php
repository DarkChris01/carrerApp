<?php

namespace App\Services;

use App\Models\Job;
use App\Models\User;
use App\Models\Entretien;


class EntretienService
{

    public function create(array $data)
    {
        $entretien = Entretien::create($data);

        return $entretien;
    }

    public function update(Entretien $entretien, $data)
    {
        $entretien = $entretien->update($data);
    }

    public function destroy(Entretien $entretien)
    {
        $entretien->delete();
    }

    public function destroyAll(User $user)
    {
        Entretien::whereIn("", $user->jobs()->get("id"))
            ->where("status", "!==", "accepted")
            ->delete();
    }


    public function accepted(Entretien $entretien)
    {
        $entretien->update([
            "status" => "process"
        ]);
    }

    public function rejected(Entretien $entretien)
    {
        $entretien->update([
            "status" => "rejected"
        ]);
    }

    public function get_entretiens_for_user(User $user)
    {
        $response = [];
        $candidacies = $user->cv?->candidacies()
            ->where("status", "process")
            ->get();

        if ($candidacies) {
            foreach ($candidacies as $candidacy) {
                $response[] = $candidacy->entretien->with(["job" => function ($query) {
                    return $query->with("enterprise");
                }])->first();
            }
        }
        return $response;
    }
}
