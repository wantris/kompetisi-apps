<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class invitationTeamMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nama, $event_name, $id_detail)
    {
        $this->nama = $nama;
        $this->event_name = $event_name;
        $this->id_detail = $id_detail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('sievent@gmail.com')
            ->view('emails.invitation_mail')
            ->with(
                [
                    'nama' => $this->nama,
                    'nama_event' => $this->event_name,
                    'id_detail' => $this->id_detail
                ]
            );
    }
}
