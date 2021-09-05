<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailWadir3 extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($event, $ormawa)
    {
        $this->event = $event;
        $this->ormawa = $ormawa;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('sievent@gmail.com')
            ->view('email.event_notif_wadir')
            ->with(
                [
                    'event' => $this->event,
                    'ormawa' => $this->ormawa
                ]
            );
    }
}
