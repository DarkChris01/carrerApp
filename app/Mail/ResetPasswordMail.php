<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use function Laravel\Prompts\password;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    private $password;
    /**
     * Create a new message instance.
     */
    public function __construct(string $password)
    {
        $this->password = $password;
    }

 
    /**
     * construct the message content definition.
     */
    public function build()
    {
        return $this->markdown('emails.ResetPassword')
            ->subject("Vous venez de reinitialiser votre mot de passe")
            ->with("password", $this->password);
    }
}
