<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Candidacy;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewCandidatureNotification extends Notification
{
    use Queueable;
    public $candidature;
    public $sender;
    /**
     * Create a new notification instance.
     */
    public function __construct(Candidacy $candidature, User $sender)
    {
        $this->candidature = $candidature;
        $this->sender = $sender;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database',"mail"];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)

            ->subject("Nouvelle candidature recu")
            ->greeting("Bonjour,")
            ->line("{$this->sender->name} a postuler pour le poste {$this->candidature->job->poste} publié le {$this->candidature->job->created_at}.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'sender' => $this->sender->only("id", "name"),
            'candidature' => $this->candidature->id,
            'content' => "Vous avez une nouvelle candidature pour le poste de {$this->candidature->job->poste}",
            'cv' => $this->sender->cv->only("id"),
            'job'=>$this->candidature->job->only("id")
        ];
    }
}
