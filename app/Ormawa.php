<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Serializable;

class Ormawa extends Model
{
    protected $primaryKey = "id_ormawa";

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];
}
