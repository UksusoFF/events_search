<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Source
 *
 * @property int $id
 * @property string $type
 * @property int $user_id
 * @property string $source
 * @property string $map_id
 * @property string $map_title
 * @property string $map_desc
 * @property string $map_image
 * @property string $map_date
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property-read mixed $resource_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereMapTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source whereSource($value)
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
        'map_id',
        'map_title',
        'map_desc',
        'map_image',
        'map_date',
    ];

    protected $hidden = [
    ];

    protected $dates = [
        'updated_at',
        'created_at',
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
