<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Enterprise;
use Illuminate\Http\Request;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EmployerInvitationNotification;

class NotificationController extends Controller
{

    public function __construct(private NotificationService $notificattionService) {}

    public function index(Request $request)
    {
        return inertia("Notifications/index");
    }

    public function markAsread($notification, Request $request)
    {
        if ($request->user("employer")) {
            $request->user("employer")
                ->enterprise
                ->unreadNotifications()
                ->where("id", $notification)
                ->get()
                ->markAsread();
        } else {
            $request->user()
                ->notifications()
                ->where("id", $notification)
                ->get()
                ->markAsread();
        }
    }

    public function markAllAsread(Request $request)
    {

        if ($request->user("employer")) {
            $request->user("employer")
                ->enterprise
                ->unreadNotifications
                ->markAsread();

            return ($request->user("employer")
                ->enterprise
                ->notifications()
                ->with("notifiable")
                ->orderby("created_at", "DESC")
                ->get());
        } else if ($request->user()) {
            $request->user()
                ->unreadNotifications
                ->markAsread();

            return ($request->user()
                ->notifications()
                ->with("notifiable")
                ->orderby("created_at", "DESC")
                ->get());
        }
    }

    public function delete($notification, Request $request)
    {
        if ($request->user("employer")) {
            $request->user('employer')
                ->enterprise
                ->notifications()
                ->where("id", $notification)
                ->delete();
        } else {
            $request->user()
                ->enterprise
                ->notifications()
                ->where("id", $notification)
                ->delete();
        }
    }

    public function deleteAll(Request $request)
    {

        if ($request->user("employer")) {
            $request->user('employer')
                ->enterprise
                ->notifications()
                ->delete();
        } else {
            $request->user()
                ->enterprise
                ->notifications()
                ->delete();
        }
    }

    public function sendInvitation(request $request)
    {
        $request->validate([
            "user" => ["required", "string", "exists:users,id"],
            "content" => ["required", "string", "max:1000"],
        ]);

        $this->notificattionService
            ->NotifyUserWithInvitation($request->user("employer")
                ->enterprise, $request->input("content"), User::where("id", $request->input("user"))
                ->first());
    }
}
