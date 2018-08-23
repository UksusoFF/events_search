<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Source
 *
 * @property int $id
 * @property string $type
 * @property int $user_id
 * @property string $title
 * @property string $source
 * @property string $map_items
 * @property string $map_id
 * @property string $map_title
 * @property string $map_description
 * @property string $map_image
 * @property string $map_date
 * @property string $map_date_format
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapDateFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereUserId($value)
 * @mixin \Eloquent
 */
class Source extends Model
{
    protected $fillable = [
        'type',
        'user_id',
        'source',
        'map_items',
        'map_id',
        'map_title',
        'map_description',
        'map_image',
        'map_date',
        'map_date_format',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
