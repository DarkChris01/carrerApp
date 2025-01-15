<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\Enterprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\CreateEnterpriseRequest;
use App\Notifications\ContactUsNotification;
use App\Services\NotificationService;

class EnterpriseController extends Controller
{
    public function __construct(private NotificationService $notificationService) {}

    public function create(Request $request)
    {
        $enterprise = Enterprise::where("employer_id", $request->user("employer")->id)->first();

        return inertia("Enterprise/Create", ['enterprise' => $enterprise]);
    }

    public function store(CreateEnterpriseRequest $request)
    {
        $request->authorize();

        //  verification et initialisation d'une instance du model enterprise 
        //  si l'entreprise existe deja elle est recuperé , sinon elle est crée de zero
        $enterprise = $request->user('employer')->enterprise ?? new Enterprise();
        // 

        $enterprise->employer_id = $request->user('employer')->id;
        $enterprise->name = $request->name;
        $enterprise->company_name = $request->company_name;
        $enterprise->phone = $request->phone;
        $enterprise->country = $request->country;
        $enterprise->region = $request->region;
        $enterprise->facebook = $request->facebook;
        $enterprise->linkedin = $request->linkedin;
        $enterprise->email = $request->email;
        $enterprise->type = $request->type;
        $enterprise->postal = $request->postal;
        $enterprise->twitter = $request->twitter;
        $enterprise->address = $request->address;
        $enterprise->sectors = json_encode($request->sectors);

        if ($request->logo) {
            $path = Storage::disk("public")->put("logo", $request->logo);
            $enterprise->logo = "/storage/" . $path;
        }
        //enregistrement du model enterprise
        $enterprise->save();
        return to_route("entreprise.show");
    }



    public function show(Request $request)
    {
        return inertia("Enterprise/Index", [
            'enterprise' => $request->user("employer")
                ->enterprise
                ->first()
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            "password" => ['required', 'string', 'current_password:employer']
        ]);

        $request->user("employer")
            ->enterprise()
            ->delete();
        return to_route("employer.home");
    }

    public function retrieve_all_enterprise()
    {
        return response()->json(Enterprise::get(["id", "name"]));
    }

    public function show_enterprise(Enterprise $enterprise)
    {
        return inertia("Visit/Presentation-entreprise", [
            "enterprise" => $enterprise->with(["employer" => function ($query) {
                return $query->with(["jobs" => function ($query) {
                    return $query->where("expired_at", ">", now())
                        ->with(["enterprise", "competence"]);
                }]);
            }])->first()
        ]);
    }

    public function contactUs(Request $request)
    {
        $request->validate([
            "message" => ["required", "string"],
            "enterprise" => ["required", "string", "exists:enterprises,id"],
            "subject" => ["required", "string"]
        ]);

        $this->notificationService->contactUsNotification(Enterprise::find($request->enterprise), $request->subject, $request->message, $request->user());
    }
}
