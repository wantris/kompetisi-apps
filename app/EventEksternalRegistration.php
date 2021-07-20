<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventEksternalRegistration extends Model
{
    protected $primaryKey = "id_event_eksternal_registration";

    public function eventEksternalRef()
    {
        return $this->belongsTo(EventEksternal::class, 'event_eksternal_id', 'id_event_eksternal');
    }

    public function mahasiswaRef()
    {
        return $this->belongsTo(Pengguna::class, 'nim', 'nim');
    }

    public function participantRef()
    {
        return $this->belongsTo(Participant::class, 'participant_id', 'id_participant');
    }

    public function timRef()
    {
        return $this->belongsTo(TimEvent::class, 'tim_event_id', 'id_tim_event');
    }
}
