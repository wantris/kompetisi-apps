<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SertifikatEventInternal extends Model
{
    protected $primaryKey = "id_sertif_internal";

    protected $appends = ['file_url'];

    public function getFileUrlAttribute($value)
    {
        return request()->getSchemeAndHttpHost() . '/assets/file/berkas-sertifikat/' . $this->filename;
    }
}
