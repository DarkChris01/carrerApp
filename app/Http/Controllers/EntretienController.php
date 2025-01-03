<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use App\Models\Job;
use App\Models\User;
use App\Models\Candidacy;
use App\Models\Entretien;
use Illuminate\Http\Request;
use App\Events\DeleteEntretienEvent;
use App\Services\NotificationService;
use App\Events\NewEntretienCreatedEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewEntretienNotification;
use App\Notifications\DeleteEntretienNotification;
use App\Notifications\UpdateEntretienNotification;
use App\Services\EntretienService;
use Exception;

class EntretienController extends Controller
{
    public  function __construct(private NotificationService $notificationService, private EntretienService $entretienService) {}

    public function userInterviews(Request $request)
    {
        return $this->entretienService->get_entretiens_for_user($request->user());
    }

    public function index(Request $request)
    {
        $entretiens = Entretien::whereIn("job_id", $request->user('employer')
            ->jobs()
            ->get("id"))
            ->with(["candidacy" => function ($query) {
                return $query->with(["cv" => function ($query) {
                    $query->with("user");
                }]);
            }, "job"])
            ->when($request->entretien, function ($query) use ($request) {
                return   $query->where("id", $request->entretien);
            })
            ->get();

        return inertia("Employer/Entretiens/index", ["entretiens" => $entretiens]);
    }

    public function store(Request $request)
    {
        $candidacy = Candidacy::find($request->input("candidacy_id"));
        $validated = $request->validate([
            "candidacy_id" => ["required", "integer", "exists:candidacies,id"],
            "date" => ["required", "date"],
            "time" => ["required"],
            "lieu" => ["required", "string", "max:100"],
            "job_id" => ["required", "string", "exists:jobs,id"]
        ]);

        try {

            $entretien = $this->entretienService->create($validated);

            $candidacy->update(["status" => "OK"]);

            $this->notificationService->NotifyUserWhenInterviewIsValided($candidacy->cv->user, $entretien, Job::find($request->job_id)->employer);

            return ($entretien->with(["candidacy" => function ($query) {
                $query->with(["cv" => function ($query) {
                    return $query->with("user");
                }]);
            }])
                ->orderby("date")
                ->first());
        } catch (\Throwable $th) {
            return back()->with("error", "Une erreur est survenue !");
        }
    }

    public function update(Request $request, Entretien $entretien)
    {
        $validated = $request->validate([
            "date" => ["required", "date"],
            "time" => ["required"],
            "lieu" => ["required", "string", "max:100"],
        ]);

        try {
            $this->entretienService->update($entretien, $validated);
            $this->notificationService->NotifyUserWhenInterviewIsUpdated($entretien, $request->user("employer")->enterprise);
        } catch (\Throwable $th) {
            return back()->with("error", "Une erreur est survenue");
        }
    }


    public function delete(Entretien $entretien)
    {
        try {
            if ($this->entretienService->destroy($entretien)) {
                Notification::send($entretien->candidacy->cv->user, new DeleteEntretienNotification($entretien));
                $entretien->candidacy->update(["status" => "rejected"]);
            } else {
                return new Exception("error occured");
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteAll(Request $request)
    {
        $this->entretienService->destroyAll($request->user());
    }

    public function accepted(Entretien $entretien)
    {
        $this->entretienService->accepted($entretien);
    }

    public function rejected(Entretien $entretien)
    {
        $this->entretienService->rejected($entretien);
    }
}
