<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\EventCheckMark
 *
 * @property int $event_id
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventCheckMark whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventCheckMark whereUserId($value)
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