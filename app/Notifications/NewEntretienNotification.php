<?php

namespace App\Notifications;

use App\Models\Entretien;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewEntretienNotification extends Notification
{
    use Queueable;

    public $entretien;
    public $sender;

    /**
     * Create a new notification instance.
     */
    public function __construct($entretien, $sender)
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
            ->subject("Confirmation d'entretien d'embauche")
            ->greeting("Bonjour {$notifiable->firstName},")

            ->line("nous sommes ravi de vous confirmer que vous avez été selectionné pour un entretien d'embauche pour le post de {$this->entretien->job->poste} au sein de notre entreprise.")
            ->line("Date: {$this->entretien->date}")
            ->line("Heure: {$this->entretien->time}")
            ->line("Lieu: {$this->entretien->lieu}")
            ->line("Nous vous remercions de l'interêt porté à notre entreprise et nous sommes impatients de discuter avec vous de vos qualifications.")
            ->line("En cas de preoccupations n'hésitez pas à nous contacter !")
            ->line("Cordialement,")
            ->line("{$this->sender->name} ({$this->sender->post_}).")
            ->line("{$this->sender->enterprise->name}.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            "sender" => $this->sender->enterprise,
            "content" => "Nous sommes ravi de vous confirmer que vous candidature au poste de  ".strtoupper($this->entretien->job->poste)." a été validée, vous avez un entretien"
        ];
    }
}
