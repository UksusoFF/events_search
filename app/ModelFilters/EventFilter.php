<?php

namespace App\ModelFilters;

use App\Models\Tag;
use Carbon\Carbon;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

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

    public function tags($ids)
    {
        $searchParts = [];

        foreach ($ids as $id) {
            $tag = Tag::find($id);
            $searchParts = array_merge(explode('|', $tag->name), $searchParts);
        }

        return $this->where(function (Builder $query) use ($searchParts) {
            foreach ($searchParts as $searchPart) {
                $query->orWhere('events.description', 'LIKE', '%' . $searchPart . '%')
                    ->orWhere('events.title', 'LIKE', '%' . $searchPart . '%');
            }
            return $query;
        });
    }

    public function sources($ids)
    {
        return $this->whereIn('events.source_id', $ids);
    }
}