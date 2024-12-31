<?php

namespace App\Notifications;

use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewJobCreatedNotification extends Notification
{
    use Queueable;
    public $sender;
    public $job;
    /**
     * Create a new notification instance.
     */
    public function __construct(Job $job, $sender)
    {
        $this->job = $job;
        $this->sender = $sender;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Nouvelle offre d'emploi")
            ->greeting("Bonjour Mr {$notifiable->firstName},")
            ->line("{$this->job->enterprise->name} recherche un {$this->job->poste}.")
            ->line("Date limite de depot des candidatures {$this->job->expired}.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            "sender" => $this->sender->enterprise->only(["name", "logo"]),
            "job" => $this->job->only(["poste", "country", "id"]),
            "content" => "a publié une nouvelle offre d'emploi",
        ];
    }
}
