<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventEksternal extends Model
{
    protected $primaryKey = "id_event_eksternal";

    protected $casts = [
        'created_at' => 'date:Y-m-d',
    ];

    public function cakupanOrmawaRef()
    {
        return $this->hasOne(CakupanOrmawa::class,  'id_cakupan_ormawa', 'cakupan_ormawa_id');
    }

    public function kategoriRef()
    {
        return $this->hasOne(KategoriEvent::class, 'id_kategori', 'kategori_id');
    }

    public function tipePesertaRef()
    {
        return $this->hasOne(TipePeserta::class, 'id_tipe_peserta', 'tipe_peserta_id');
    }

    public function pengajuanRef()
    {
        return $this->belongsTo(EventInternalDetail::class, 'event_internal_id',  'id_event_internal');
    }
}