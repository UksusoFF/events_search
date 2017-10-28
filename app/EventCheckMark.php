<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCheckMark extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'event_id',
        'user_id',
    ];
}