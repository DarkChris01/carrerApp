<?php


namespace App\Services;
use Illuminate\Support\Facades\Auth;

class UserService
{

    // retrieve all the cv data
    public function cv()
    {
        return Auth::user()
            ->cv
            ->with(["experience", "competence", "formation"])
            ->first();
    }

    // retrieve all user candidacies
    public function candidatures()
    {
        return $this
            ->cv()
            ->candidacies()
            ->with("job")->get();
    }

    // retrieve all the notifications for this specific user
    public function notifications()
    {
        return Auth::user()
            ->notifications;
    }


    // retrieve the user abonnement
    public function abonnement()
    {
        return Auth::user()
            ->abonnement;
    }
}
