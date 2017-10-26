<?php

namespace App;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Venturecraft\Revisionable\RevisionableTrait as Revisionable;

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
        'checked',
        'ignored',
    ];

    protected $fillable = [
        'vid',
        'name',
        'description',
        'photo_200',
        'start_date',
        'checked',
        'ignored',
    ];

    protected $dates = [
        'start_date',
    ];
}