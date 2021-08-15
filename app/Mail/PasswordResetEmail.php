<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pengguna, $token)
    {
        $this->pengguna = $pengguna;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('sievent@gmail.com')
            ->view('emails.password_reset')
            ->with(
                [
                    'pengguna' => $this->pengguna,
                    'token' => $this->token
                ]
            );
    }
}
