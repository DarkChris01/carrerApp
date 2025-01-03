<?php

namespace App\Http\Controllers;

use App\Models\Enterprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreateEnterpriseRequest;
use App\Models\Sector;

class EnterpriseController extends Controller
{
    public function create(Request $request)
    {
        $enterprise = Enterprise::where("employer_id", $request->user("employer")->id)
            ->with("sector")->first();

        return inertia("Enterprise/Create", ['enterprise' => $enterprise]);
    }

    public function store(CreateEnterpriseRequest $request)
    {
        $request->authorize();

        //  verification et initialisatio d'une instance du model enterprise 
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
        $enterprise->address = $request->address;

        if ($request->logo) {
            $path = Storage::disk("public")->put("logo", $request->logo);
            $enterprise->logo = "/storage/" . $path;
        }

        $enterprise->save();

        if ($enterprise) {
            if ($enterprise->sector) {
                $sector = $enterprise->sector;
            } else {
                $sector = new Sector();
                $sector->enterprise_id = $enterprise->id;
            }
        } else {
            $sector = new Sector();
            $sector->enterprise_id = $enterprise->id;
        }

        $sector->sector1 = strtolower($request->sector1);
        $sector->sector2 = strtolower($request->sector2);
        $sector->sector3 = strtolower($request->sector3);
        $sector->sector4 = strtolower($request->sector4);
        $sector->save();

        return to_route("entreprise.show");
    }

    public function show(Request $request)
    {
        return inertia("Enterprise/Index", ['enterprise' => $request->user("employer")
            ->enterprise->with("sector")
            ->first()]);
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
        return Enterprise::get(["id", "name"]);
    }

    public function show_enterprise(Enterprise $enterprise)
    {
        return inertia("User/Visit_enterprise", [
            "enterprise" => $enterprise->with(["employer", "sector", "employer" => function ($query) {
                return $query->with(["jobs" => function ($query) {
                    return $query->with(["enterprise","competence"]);
                }]);
            }])->first()
        ]);
    }
}
