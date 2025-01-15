<?php

namespace App\Services;

use App\Models\Cv;
use App\Models\Job;
use App\Models\User;
use App\Models\Employer;
use App\Models\Candidacy;
use App\Models\Entretien;
use App\Models\Enterprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\NewEntretienCreatedEvent;
use App\Notifications\ApprouvedNotification;
use App\Notifications\ContactUsNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewEntretienNotification;
use App\Notifications\NewJobCreatedNotification;
use App\Notifications\NewCandidatureNotification;
use App\Notifications\DeleteEntretienNotification;
use App\Notifications\UpdateEntretienNotification;
use App\Notifications\EmployerInvitationNotification;
use App\Notifications\NotifyWhereUserSelectedForJob;


class NotificationService
{

    public function NotifiyUserWhenNewJobIsCreated(Collection|User $user, Job $job)
    {
        Notification::send($user, new NewJobCreatedNotification($job, Auth::guard("employer")->user()));
    }

    public function NotifyUserWhenApplicationIsApprouved(Cv $cv)
    {
        Notification::send($cv, new ApprouvedNotification());
    }


    public function NotifyUserWhenInterviewIsCancel(Entretien $entretien)
    {
        Notification::send($entretien->user, new DeleteEntretienNotification($entretien));
    }

    public function NotifyUserWhenInterviewIsValided(User $user, Entretien $entretien, Employer $employer)
    {
        Notification::send($user, new NewEntretienNotification($entretien, $employer));
    }


    public function NotifyUserWhenInterviewIsUpdated(Entretien $entretien, Enterprise $enterprise)
    {
        Notification::send($entretien->user, new UpdateEntretienNotification($entretien, $enterprise));
    }

    public function NotifyEmployerWhenNewApplicationIsAdded(Candidacy $application, User $user, Enterprise $enterprise)
    {
        Notification::send($enterprise, new NewCandidatureNotification($application, $user));
    }


    public function NotifyUserWithInvitation(Enterprise $enterprise, $content, User $user)
    {
        Notification::send($user, new EmployerInvitationNotification($enterprise, $content));
    }

    public function NotifyWhereUserSelectedForJob(Candidacy $candidacy)
    {

        Notification::send($candidacy->cv->user, new NotifyWhereUserSelectedForJob($candidacy->job->employer->enterprise, $candidacy)); //prend en parametre entretien et la candidature
    }

    public function contactUsNotification($enterprise, $subject, $content, User $user)
    {

        Notification::send(Enterprise::find($enterprise), new ContactUsNotification($subject, $content, $user));
    }
}
