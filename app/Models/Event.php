<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Venturecraft\Revisionable\RevisionableTrait as Revisionable;

/**
 * App\Models\Event
 *
 * @property int $id
 * @property int $source_id
 * @property string $uuid
 * @property string|null $title
 * @property string|null $url
 * @property string|null $description
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $date
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @property-read int|null $revision_history_count
 * @property-read \App\Models\Source $source
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereUuid($value)
 * @mixin \Eloquent
 */
class Event extends Model
{
    use Filterable;

    use Sortable;

    public $sortable = [
        'date',
        'updated_at',
        'created_at',
    ];

    use Revisionable;

    protected $fillable = [
        'uuid',
        'source_id',
        'title',
        'url',
        'description',
        'image',
        'date',
    ];

    protected $dates = [
        'date',
        'updated_at',
        'created_at',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}
