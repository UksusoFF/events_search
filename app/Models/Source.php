<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{

    protected $fillable = [
        "type",
        "user_id",
        "source",
        "map_id",
        "map_title",
        "map_desc",
        "map_image",
        "map_date",

    ];

    protected $hidden = [

    ];

    protected $dates = [
        "updated_at",
        "created_at",

    ];

    protected $appends = [
        'resource_url',
    ];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/sources/' . $this->getKey());
    }

}
