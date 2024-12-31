<?php

namespace App\Services;

use App\Models\User;
use App\Models\Employer;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class ResetPasswordService
{
    public function reset($email, $newPassword)
    {
        $user = User::where("email", $email)->first() ?? Employer::where("email", $email)->first();

        Mail::to($user)->send(new ResetPasswordMail($newPassword));

        if ($user->update(["password" => Hash::make($newPassword)])) {
            return to_route("login")
                ->with("success", "Votre mot de passe a été reinitialisé veuillez vous connecter à votre compte email !");
        }
    }
}
