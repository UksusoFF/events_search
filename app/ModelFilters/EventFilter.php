<?php

namespace App\ModelFilters;

use App\Tag;
use Carbon\Carbon;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

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

    public function tags($ids)
    {
        $searchParts = [];

        foreach ($ids as $id) {
            $tag = Tag::find($id);
            $searchParts = array_merge(explode('|', $tag->name), $searchParts);
        }

        return $this->where(function (Builder $query) use ($searchParts) {
            foreach ($searchParts as $searchPart) {
                $query->orWhere('description', 'LIKE', '%' . $searchPart . '%')
                    ->orWhere('title', 'LIKE', '%' . $searchPart . '%');
            }
            return $query;
        });
    }

    public function sources($ids) {
        return $this->where(function (Builder $query) use ($ids) {
            foreach ($ids as $id) {
                $query->orWhere('uuid', 'LIKE', "%\_{$id}\_%");
            }
            return $query;
        });
    }
}