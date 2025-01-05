<?php

namespace App\Notifications;

use App\Models\Candidacy;
use App\Models\Enterprise;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotififyWhereUserSelectedForJob extends Notification implements ShouldQueue
{
    use Queueable;
    public $enterprise;
    public $candidacy;

    /**
     * Create a new notification instance.
     */
    public function __construct(Enterprise $enterprise, Candidacy $candidacy)
    {
        $this->enterprise = $enterprise;
        $this->candidacy = $candidacy;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', "database"];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Emploi obtenu")
            ->greeting("Felicitation , Mr {$notifiable->name}")
            ->line("Nous sommes honorés de vous confirmer votre recrutement au le poste de  {$this->candidacy->job->poste} ")
            ->line("Nous vous recontacterons pour plus de details !")
            ->line("Bienvenu chez {$this->enterprise->name}");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            "enterprise" => $this->enterprise,
            "content" => "Nous sommes honorés de vous confirmer votre recrutement au le poste de  {$this->candidacy->job->poste} Nous vous recontacterons pour plus de details !Bienvenu chez {$this->enterprise->name}"
        ];
    }
}
