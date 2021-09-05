<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SertifikatEventEksternal extends Model
{
    protected $primaryKey = "id_sertif_eksternal";

    protected $appends = ['file_url'];

    public function getFileUrlAttribute($value)
    {
        return request()->getSchemeAndHttpHost() . '/assets/file/berkas-sertifikat/' . $this->filename;
    }
}
