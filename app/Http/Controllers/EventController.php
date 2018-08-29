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
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $events = $user->events()->where('date', '>=', Carbon::now());

        $tags = $user->tags->map(function ($tag) use ($events) {
            $tag->count = with(clone $events)
                ->filter([
                    'tags' => [
                        $tag->id,
                    ],
                ])
                ->count();
            return $tag;
        })->sortByDesc('count');

        $sources = $user->sources->map(function ($source) use ($events) {
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

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Components\EventComponent $eventComponent
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function check(Request $request, EventComponent $eventComponent)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        try {
            $eventComponent->refresh($user->sources);

            $message = [
                'level' => 'success',
                'text' => 'Events successfully updated!',
            ];
        } catch (Exception $e) {
            $message = [
                'level' => 'error',
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
            'message' => $message,
        ]);
    }
}