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
use Carbon\Carbon;
use Exception;

class InterviewController extends Controller
{
    public  function __construct(private NotificationService $notificationService, private EntretienService $entretienService) {}



    public function index(Request $request)
    {
        $jobs = $request->user('employer')->jobs()->get("id");

        $entretiens = Entretien::whereIn("job_id", $jobs)
            ->with(["candidacy" => function ($query) {
                return $query->with(["cv" => function ($query) {
                    $query->with("user");
                }]);
            }, "job"])
            ->whereDate("date", ">=", Carbon::now()->day())
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
            $candidacy->update(["status" => "process"]);
            $this->notificationService->NotifyUserWhenInterviewIsValided($candidacy->cv->user, $entretien, Job::find($request->job_id)->employer);

            $newEntretien = $entretien->with(["candidacy" => function ($query) {
                $query->with(["cv" => function ($query) {
                    return $query->with("user");
                }]);
            }])
                ->orderby("date")
                ->first();
            return to_route("entretiens.index");
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
            $this->entretienService->destroy($entretien);
            $entretien->candidacy->update(["status" => "rejected"]);
            Notification::send($entretien->candidacy->cv->user, new DeleteEntretienNotification($entretien));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteAll(Request $request)
    {
        $this->entretienService->destroyAll($request->user("employer"));
    }

    public function accepted(Entretien $entretien)
    {
        $this->entretienService->accepted($entretien);
    }

    public function rejected(Entretien $entretien)
    {
        $this->entretienService->rejected($entretien);
    }

    public function userInterviews(Request $request)
    {
        return $this->entretienService->get_entretiens_for_user($request->user());
    }
}
