<?php

namespace App\Http\Controllers;

use App\Components\EventComponent;
use App\Models\Event;
use App\Models\EventCheckMark;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::where('start_date', '>=', Carbon::now());

        $tags = auth()->user()->tags->map(function ($tag) use ($events) {
            return [
                'id' => $tag->id,
                'name' => $tag->name,
                'title' => head(explode('|', $tag->name)),
                'count' => with(clone $events)
                    ->filter(['search' => explode('|', $tag->name)])
                    ->count(),
            ];
        })->sortByDesc('count');

        return view('events.index', [
            'events' => $events
                ->filter($request->input('f', []))
                ->sortable(['start_date'])
                ->paginate(),
            'tags' => $tags,
        ]);
    }

    public function show(Request $request, Event $event)
    {
        return view('events.show', [
            'event' => $event,
        ]);
    }

    public function read(Request $request, Event $event)
    {
        $eventCheckMark = new EventCheckMark([
            'event_id' => $event->id,
            'user_id' => auth()->id(),
        ]);
        $eventCheckMark->save();

        return redirect()->back();
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