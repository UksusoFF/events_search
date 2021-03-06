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
 * @property string|null $map_url
 * @property string|null $map_description
 * @property string|null $map_image
 * @property string|null $map_date
 * @property string|null $map_date_format
 * @property string|null $map_date_regex
 * @property int $disabled
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property string|null $tags
 * @property string $report
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @property-read int|null $events_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapDateFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapDateRegex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereReport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereTags($value)
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
        'map_url',
        'map_description',
        'map_image',
        'map_date',
        'map_date_format',
        'map_date_regex',
        'tags',
        'report',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setTagsAttribute(array $value)
    {
        $this->attributes['tags'] = json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function getTagsAttribute()
    {
        return json_decode($this->attributes['tags'], true);
    }
}
