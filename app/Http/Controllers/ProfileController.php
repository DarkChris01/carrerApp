<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(): Response
    {       
        return inertia("Profile/Edit");
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);


        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return inertia('/');
    }

    public function update_avatar(Request $request)
    {

        $request->validate([
            "avatar" => ['required', "file", "mimes:png,jpg,svg,avif", "max:1000"]
        ]);
        $path = Storage::disk("public")->put("avatars", $request->avatar);


        try {
            $request->user()->avatars = "/storage/" . $path;
            $request->user()->save();
        } catch (\Throwable $th) {
            throw new \Exception($th);
        }
    }
}
