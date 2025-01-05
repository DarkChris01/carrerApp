<?php

namespace App\Http\Middleware;

use App\Models\Archive;
use App\Models\Candidacy;
use Inertia\Middleware;
use App\Models\Entretien;
use Illuminate\Http\Request;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $enterprise = null;
        $entretiens = 0;
        $candidatures = 0;
        $notifications = [];

        if ($request->user("employer")) {
            if ($request->user("employer")->enterprise) {
                $enterprise = $request->user("employer")->enterprise->with("sector")->first();

                $entretiens = Entretien::whereIn("job_id", $request->user('employer')->jobs()->get("id"))
                    ->with(["candidacy" => function ($query) {
                        $query->with(["cv" => function ($query) {
                            $query->with("user");
                        }]);
                    }, "job"])
                    ->orderby("date")
                    ->get();

                $notifications = $request->user("employer")
                    ->enterprise
                    ->notifications()
                    ->with(["notifiable"])
                    ->orderby("created_at", "DESC")
                    ->get();
            }
        } else if ($request->user()) {
            $archived = $request->user()->archives()->get("archivable_id");
            $enterprise = [];
            if ($request->user()->cv) {
                $candidatures = Candidacy::where("cv_id", $request->user()->cv->id)
                    ->whereNotIn("id", $archived)
                    ->count();
                $entretiens = $request->user()->cv->candidacies->where("status", "process")?->count();
            } else {
                $candidatures = 0;
                $entretiens = 0;
            }
            $notifications = $request->user()
                ->notifications()
                ->with(["notifiable"])
                ->orderby("created_at", "DESC")
                ->get();
        }
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user() ?? $request->user("employer"),
                "enterprise" => $enterprise,
                "entretiens" => $entretiens,
                "candidacies" => $candidatures,
                "notifications" => $notifications,
                "isEmployer" => $request->user("employer") ? true : false
            ],
            'flash' => [
                'success' => fn() => $request->session()->get('success'),
                'error' => fn() => $request->session()->get('error')
            ]
        ];
    }
}
