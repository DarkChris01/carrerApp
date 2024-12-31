<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EmployerController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'post_' => 'required|string|max:50',
            'email' => 'required|string|lowercase|email|max:255|unique:' . Employer::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $Employer = Employer::create([
            'name' => $request->name,
            'email' => $request->email,
            'post_' => $request->post_,
            'password' => Hash::make($request->password),
            'avatars' => "/storage/avatars/default/man.png"
        ]);

        // register envoie verification par mail apres la creation du compte 
        event(new Registered($Employer));

        Auth::guard("employer")->login($Employer);

        return to_route("employer.home");
    }

    public function show(Request $request)
    {
        return Inertia("Employer/Auth/Profile", ["user" => $request->user("employer")
            ->with("enterprise")->first(["post_ as poste", "avatars", "name", "id", "email"])]);
    }

    public function udpate_avatar(Request $request)
    {
        $request->validate([
            "avatar" => ['required', "file", "max:1200"],
        ]);

        $path = Storage::disk('public')->put("avatars", $request->avatar);

        $user = $request->user('employer');
        $user->avatars = "/storage/" . $path;
        $user->save();
    }

    public function update_data(Request $request)
    {
        $request->validate([
            "name" => ["required", "string", "min:5"],
            "email" => ["required", "email"],
            "poste" => ["required", "string"]
        ]);

        $user = $request->user('employer');
        $user->name = $request->name;
        $user->email = $request->email;
        $user->post_ = $request->poste;
        $user->save();
    }

    public function Authenticate(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);


        if (Auth::guard('employer')->attempt(['email' => $request->email, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            $employer = Employer::where('email', $request->email)->first();
            Auth::guard("employer")->login($employer);

            return to_route("employer.home");
        }

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    public function destroy(Request $request)
    {
        Auth::guard('employer')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
