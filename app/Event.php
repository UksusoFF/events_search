<?php

namespace App;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Event extends Model
{
    use Filterable;

    use Sortable;

    public $sortable = [
        'created_at',
        'updated_at',
        'start_date',
    ];

    protected $fillable = [
        'vid',
        'name',
        'description',
        'start_date',
    ];

    protected $dates = [
        'start_date',
    ];
}