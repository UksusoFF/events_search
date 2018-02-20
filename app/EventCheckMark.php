<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\EventCheckMark
 *
 * @mixin \Eloquent
 */
class EventCheckMark extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'event_id',
        'user_id',
    ];
}