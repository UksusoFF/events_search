<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EventCheckMark
 *
 * @property int $event_id
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventCheckMark whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EventCheckMark whereUserId($value)
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