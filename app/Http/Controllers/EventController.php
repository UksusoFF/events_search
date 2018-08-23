<?php

namespace App\Http\Controllers;

use App\Components\EventComponent;
use App\Models\Event;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::where('date', '>=', Carbon::now());

        $tags = auth()->user()->tags->map(function ($tag) use ($events) {
            $tag->count = with(clone $events)
                ->filter([
                    'tags' => [
                        $tag->id,
                    ],
                ])
                ->count();
            return $tag;
        })->sortByDesc('count');

        $sources = auth()->user()->sources->map(function ($source) use ($events) {
            $source->count = with(clone $events)
                ->filter([
                    'sources' => [
                        $source->id,
                    ],
                ])
                ->count();
            return $source;
        })->sortByDesc('count');

        return view('events.index', [
            'events' => $events
                ->filter($request->input('f', []))
                ->sortable(['date'])
                ->paginate(),
            'tags' => $tags,
            'sources' => $sources,
        ]);
    }

    public function show(Request $request, Event $event)
    {
        return view('events.show', [
            'event' => $event,
        ]);
    }

    public function check(Request $request, EventComponent $eventComponent)
    {
        try {
            $eventComponent->refresh();

            $result = [
                'success' => true,
                'text' => 'Events successfully updated!',
            ];
        } catch (Exception $e) {
            logger()->error($e->getMessage());
            $result = [
                'success' => false,
                'text' => $e->getMessage(),
            ];
        }

        return redirect()->action('EventController@index', [
            'f' => [
                'created_at' => [
                    'today',
                ],
            ],
        ])->with([
            'message' => $result,
        ]);
    }
}