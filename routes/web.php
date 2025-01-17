<?php

use App\Models\Domain;

use App\Models\Candidacy;
use App\Models\Enterprise;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CvController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\AcceuilController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\CandidacyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\CompetenceController;

use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Auth\RegisteredUserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [AcceuilController::class, "index"])->name("home");
Route::get('/reset-user-password', function () {
    return inertia("Auth/ResetPassword");
});

Route::group(['prefix' => 'job'], function () {
    Route::get("/{job}", [JobController::class, "show"])->name("job.show");
});

Route::middleware('auth')->group(function () {
    Route::get("/user/get-notifications", function (Request $request) {
        return $request->user()->notifications;
    });

    Route::group(['prefix' => 'job'], function () {
        Route::get("/mon-offre/{job}", [JobController::class, "show"])->name("user.job.show");
    });

    Route::group(['prefix' => 'entretien'], function () {
        Route::get("/", [InterviewController::class, "userInterviews"])->name("user.interviews");
        Route::patch("/agree/{entretien}", [InterviewController::class, "accepted"])->name("accepted.entretien");
        Route::patch("/disgree/{entretien}", [InterviewController::class, "rejected"])->name("rejected.entretien");
    });


    Route::group(['prefix' => "candidature"], function () {
        Route::post("/postulez", [CandidacyController::class, "store"])->middleware("cv");
        Route::patch('/masquer/{candidacy}', [CandidacyController::class, 'destroy']);
        Route::delete('/{candidacy}', [CandidacyController::class, 'destroy']);
        Route::get('/', [CandidacyController::class, 'get_user_candidacies'])->name("user.candidacies");
    });
    Route::group(['prefix' => "archive"], function () {
        Route::post("/", [ArchiveController::class, "store"]);
    });


    Route::post('/store', [RegisteredUserController::class, 'store'])->name('user.store');
    Route::group(["prefix" => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/avatar', [ProfileController::class, 'update_avatar'])->name('avatar.update');
    });

    Route::group(["prefix" => 'cv'], function () {
        Route::post("/information", [CvController::class, "store"]);
        Route::post("/formation", [FormationController::class, "store"]);
        Route::post("/competence", [CompetenceController::class, "store"]);
        Route::post("/experience", [ExperienceController::class, "store"]);
        Route::get("/load-data", [CvController::class, "load_data"]);
        Route::get("/get-user-cv-information", [CvController::class, "get_user_cv_info"]);
        Route::get("/", [CvController::class, "show_cv_for_user"])->name("show.cv");
        Route::get("/personal-informations", [CvController::class, "create"])->name("informations.create");
        Route::get("/competences", [CompetenceController::class, "create"])->name("competences.create");
        Route::get("/experiences", [ExperienceController::class, "create"])->name("experiences.create");
        Route::get("/formations", [FormationController::class, "create"])->name("formations.create");
    });
    Route::group(["prefix" => "notifications"], function () {
        Route::patch("/", [NotificationController::class, "markAllAsread"]);
        Route::patch("/{notification}", [NotificationController::class, "markAsread"]);
        Route::delete("/{notification", [NotificationController::class, "destroy"])->name("destroy.notifivcation");
    });

    Route::group(["prefix" => "enterprise"], function () {
        Route::get("/{enterprise}", [EnterpriseController::class, "show_enterprise"]);
        Route::post("/contact-us", [EnterpriseController::class, "contactUs"]);
    });
});


Route::middleware("employer")->group(function () {
    Route::get("/download/{cv}", [FileController::class, "download_cv"]);
    Route::get("/dashboard", [DashboardController::class, "index"])->name("employer.home");

    Route::group(['prefix' => "my-enterprise"], function () {
        Route::get("/creer-une-entreprise", [EnterpriseController::class, "create"]);
        Route::get("/", [EnterpriseController::class, "show"])->name("entreprise.show");
        Route::post("/", [EnterpriseController::class, "store"]);
        Route::delete("/", [EnterpriseController::class, "delete"]);
        Route::patch("/", [EnterpriseController::class, "update"]);
        // Route::patch("/profile", [EnterpriseController::class]);
        Route::get("/get", function (Request $request) {
            return  $request->user('employer')->enterprise;
        });
    });

    Route::group(['prefix' => "employer"], function () {
        Route::get("/profile", [EmployerController::class, "show"])->name("profile.show");
        Route::patch("/profile", [EmployerController::class, "update_data"]);
        Route::post("/udpate/avatar", [EmployerController::class, "udpate_avatar"]);
        Route::get("/toutes-mes-offres", [JobController::class, "index"])->name("jobs.index");
        Route::get("/creer-une-offre", [JobController::class, "create"])->name("job.create");
        Route::post("/storejob", [JobController::class, "store"])->name("job.store");
        Route::post("/updatejob", [JobController::class, "update"])->name("job.update");
        Route::get("/offres-d'emploi/{job}", [JobController::class, "show"])->name("job.show");
        Route::get("/curicculum-vitae/{cv}", [CvController::class, "show_cv_for_employer"])->name("cv.show");
        Route::delete("/job", [JobController::class, "delete"])->name("job.delete");
        Route::get("/edit/jobs/{job}", [JobController::class, "edit"]);
        Route::post("/update/{job}", [JobController::class, "update"]);
        Route::get("get-dashboard-datas/{year}", [DashboardController::class, "get_dashboard_data"]);
        Route::get("/get-open-jobs-datas/{year}", [DashboardController::class, "get_open_jobs_datas"]);

        Route::group(['prefix' => 'notifications'], function () {
            Route::post('/invitation', [NotificationController::class, "sendInvitation"]);
            Route::get("/", [NotificationController::class, "index"]);
            Route::delete("/{notification}", [NotificationController::class, "destroy"]);
            Route::delete("/", [NotificationController::class, "deleteAll"]);
            Route::patch("/{notification}", [NotificationController::class, "markAsread"]);
            Route::patch("/", [NotificationController::class, "markAllAsread"]);
        });
    });

    Route::group(["prefix" => "mes-entretiens"], function () {
        Route::post("/store", [InterviewController::class, "store"]);
        Route::post("/update/{entretien}", [InterviewController::class, "update"]);
        Route::get("/", [InterviewController::class, "index"])->name("entretiens.index");
        Route::delete("/{entretien}", [InterviewController::class, "delete"]);
        Route::delete("/", [InterviewController::class, "deleteAll"]);
    });
    Route::get("/cvtheque", [CvController::class, "index"])->name("cv.index");

    Route::group(['prefix' => "candidatures"], function () {
        Route::get("/", [CandidacyController::class, "index"])->name("candidature.index");
        Route::get("/{job}", [CandidacyController::class, "show"])->name("candidature.show");
        Route::patch("/approuved/{candidacy}", [CandidacyController::class, "approuved"]);
        Route::patch("/rejected/{candidate}", [CandidacyController::class, "rejected"]);
        Route::post("/candidate-selected", [CandidacyController::class, "candidateHasSelected"]);
    });
});

Route::get("/load-enterprise", function () {
    return Enterprise::all(["name", "id"]);
});



Route::post("/domain/autocompletion", function (Request $request) {
    $request->validate([
        "word" => ["required", "min:3"]
    ]);

    return Domain::where("intitules", "REGEXP", "^$request->word")->get("intitules");
});

Route::post("/enterprise/autocompletion", function (Request $request) {
    $request->validate([
        "word" => ["required", "min:3"]
    ]);

    return Enterprise::where("name", "REGEXP", "$request->word")->get("intitules");
});

Route::get("get-most-cv", [CvController::class, "get_best_profil"]);
Route::get("rate/{cv}", [CvController::class, "rate"]);
Route::get("get-all-enterprises", [EnterpriseController::class, "retrieve_all_enterprise"]);
Route::get("/postes", [JobController::class, "retrieve_all_jobs"]);

require __DIR__ . '/auth.php';
