<?php

namespace App\Notifications;

use App\Models\Job;
use App\Models\Employer;
use App\Models\Enterprise;
use App\Models\Entretien;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UpdateEntretienNotification extends Notification
{
    use Queueable;

    public $entretien;
    public $sender;
    /**
     * Create a new notification instance.
     */
    public function __construct(Entretien $entretien, Enterprise $sender)
    {
        $this->entretien = $entretien;
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
            ->subject("Date d'entretien modifié")
            ->greeting("Bonjour Mr {$notifiable->firstName},")
            ->line("Nous vous informons que votre entretien d'embauche prevu pour le {$this->entretien->created_at} a été modifier pour la date qui suit:")
            ->line("Date: {$this->entretien->date}")
            ->line("Heure: {$this->entretien->time}")
            ->line("Lieu: {$this->entretien->lieu}")
            ->line("En cas de preoccupations n'hésitez pas à nous contacter !")
            ->line("Cordialement,")
            ->line("{$this->sender->name} ({$this->sender->post_})")
            ->line("{$this->sender->enterprise->name}");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            "sender" => $this->sender,
            "content" => "Nous vous informons que la date de votre entretien d'embauche a été modifier au {$this->entretien->date} à {$this->entretien->time} (localisation: {$this->entretien->lieu})"
        ];
    }
}
