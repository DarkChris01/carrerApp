<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Nette\Utils\Random;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use App\Rules\UserorEmployersExist;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Services\ResetPasswordService;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    private $service;

    public function __construct(ResetPasswordService $service)
    {
        $this->service = $service;
    }
    /**
     * Display the password reset link request view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $password = Random::generate();

        $request->validate([
            'email' => ['required', 'email', new UserorEmployersExist],
        ]);

        $this->service->reset($request->email, $password);

        return to_route("login")->with("success", "Votre mot depasse a été reinitialisé veuillez vous connecter à votre compte email !");
    }
}
