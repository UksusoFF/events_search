<?php

namespace App\ModelFilters;

use Carbon\Carbon;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Query\Builder;

class EventFilter extends ModelFilter
{
    public function createdAt($switch)
    {
        switch (head($switch)) {
            case 'today':
                return $this->whereDate('created_at', Carbon::today());
                break;
            default:
                return $this;
        }
    }

    public function updatedAt($switch)
    {
        switch (head($switch)) {
            case 'today':
                return $this->whereDate('updated_at', Carbon::today());
                break;
            default:
                return $this;
        }
    }

    public function search($search)
    {
        $searchParts = explode('|', implode('|', $search));
        return $this->where(function (Builder $query) use ($searchParts) {
            foreach ($searchParts as $searchPart) {
                $query->orWhere('description', 'LIKE', '%' . $searchPart . '%')
                    ->orWhere('title', 'LIKE', '%' . $searchPart . '%');
            }
            return $query;
        });
    }
}