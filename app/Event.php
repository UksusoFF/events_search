<?php

namespace App;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Venturecraft\Revisionable\RevisionableTrait as Revisionable;

/**
 * App\Event
 *
 * @property int $id
 * @property string $vid
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\EventCheckMark[] $checkMarks
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event sortable($defaultSortParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereVid($value)
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

    protected $dates = [
        'start_date',
    ];

    public function checkMarks()
    {
        return $this->hasMany(EventCheckMark::class);
    }
}