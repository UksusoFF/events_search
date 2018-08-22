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
 * @property string $vid
 * @property string $name
 * @property string $description
 * @property string $photo_200
 * @property \Carbon\Carbon|null $start_date
 * @property int $ignored
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventCheckMark[] $checkMarks
 * @property-read mixed $resource_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event sortable($defaultSortParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereIgnored($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event wherePhoto200($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereVid($value)
 * @mixin \Eloquent
 */
class Event extends Model
{
    use Filterable;

    use Sortable;

    public $sortable = [
        'created_at',
        'updated_at',
        'start_date',
    ];

    use Revisionable;

    protected $dontKeepRevisionOf = [
        'ignored',
    ];

    protected $fillable = [
        'vid',
        'name',
        'description',
        'photo_200',
        'start_date',
        'ignored',
    ];

    protected $hidden = [
    ];

    protected $dates = [
        'start_date',
        'updated_at',
        'created_at',
    ];

    protected $appends = [
        'resource_url',
    ];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/events/' . $this->getKey());
    }

    public function checkMarks()
    {
        return $this->hasMany(EventCheckMark::class);
    }
}
