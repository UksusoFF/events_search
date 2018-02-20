<?php

namespace App;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Venturecraft\Revisionable\RevisionableTrait as Revisionable;

/**
 * App\Event
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\EventCheckMark[] $checkMarks
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event sortable($defaultSortParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereLike($column, $value, $boolean = 'and')
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