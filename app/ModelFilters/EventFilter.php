<?php

namespace App\ModelFilters;

use Carbon\Carbon;
use EloquentFilter\ModelFilter;

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

    public function state($state)
    {
        switch (head($state)) {
            case 'unread':
                return $this->whereDoesntHave('checkMarks', function ($query) {
                    return $query->where('user_id', auth()->id());
                });
                break;
            default:
                return $this;
        }
    }

    public function search($search)
    {
        $searchParts = explode('|', implode('|', $search));
        return $this->where(function ($query) use ($searchParts) {
            foreach ($searchParts as $searchPart) {
                $query->orWhere('description', 'LIKE', '%' . $searchPart . '%')
                    ->orWhere('name', 'LIKE', '%' . $searchPart . '%');
            }
            return $query;
        });
    }
}