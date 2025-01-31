<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ContactUsNotification extends Notification
{
    use Queueable;
    private $content;
    private $sender;
    private $subject;
    /**
     * Create a new notification instance.
     */
    public function __construct(string $subject, string $content, User $sender)
    {
        $this->content = $content;
        $this->subject = $subject;
        $this->sender = $sender;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("{$this->subject}")
            ->line("{$this->content}");
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
            "content" => $this->content,
            "subject" => $this->subject,
        ];
    }
}
