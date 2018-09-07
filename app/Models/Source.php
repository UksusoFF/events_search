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
 * @property string|null $map_items
 * @property string|null $map_id
 * @property string|null $map_title
 * @property string|null $map_description
 * @property string|null $map_image
 * @property string|null $map_date
 * @property string|null $map_date_format
 * @property string|null $map_date_regex
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapDateFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapDateRegex($value)
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
        'title',
        'source',
        'map_items',
        'map_id',
        'map_title',
        'map_description',
        'map_image',
        'map_date',
        'map_date_format',
        'map_date_regex',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
