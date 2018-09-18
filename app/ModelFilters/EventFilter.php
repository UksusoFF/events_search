<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class EventFilter extends ModelFilter
{
    public function createdAt($switch)
    {
        switch (head($switch)) {
            case 'today':
                return $this->whereDate('events.created_at', Carbon::today());
                break;
            default:
                return $this;
        }
    }

    public function updatedAt($switch)
    {
        switch (head($switch)) {
            case 'today':
                return $this->whereDate('events.updated_at', Carbon::today());
                break;
            default:
                return $this;
        }
    }

    public function tags($tags)
    {
        return $this->where(function (Builder $query) use ($tags) {
            foreach (explode('|', implode('|', $tags)) as $tag) {
                $query->orWhere('events.description', 'LIKE', "%$tag%")
                    ->orWhere('events.title', 'LIKE', "%$tag%");
            }
            return $query;
        });
    }

    public function sources($ids)
    {
        return $this->whereIn('events.source_id', $ids);
    }
}