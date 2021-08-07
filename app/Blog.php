<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $primaryKey = "id_blog";

    protected $appends = ['image_url'];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
    ];

    public function getImageUrlAttribute($value)
    {
        return request()->getSchemeAndHttpHost() . '/assets/img/blog/' . $this->image_name;
    }
}
