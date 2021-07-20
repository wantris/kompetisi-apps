<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventEksternal extends Model
{
    protected $primaryKey = "id_event_eksternal";

    protected $casts = [
        'created_at' => 'date:Y-m-d',
    ];

    public function getDeskripsiExcerptAttribute()
    {
        return Str::words($this->deskripsi, '15');
    }

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
        return $this->hasOne(EventEksternalDetail::class, 'event_eksternal_id',  'id_event_eksternal');
    }
}
