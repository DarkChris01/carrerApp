<?php

namespace App\Notifications;

use App\Models\Entretien;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DeleteEntretienNotification extends Notification
{
    use Queueable;

    public $entretien;
    /**
     * Create a new notification instance.
     */
    public function __construct(Entretien $entretien)
    {
        $this->entretien = $entretien;
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
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            "sender" => $this->entretien->job->enterprise->only(["name", "logo"]),
            "content" => "Votre entretien prevu pour le {$this->entretien->date} à {$this->entretien->time} a été annulé, nous vous tiendront informé de l'évolution de la situation"
        ];
    }
}
