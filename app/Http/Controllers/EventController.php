<?php

namespace App\Http\Controllers;

use App\Components\EventComponent;
use App\Models\Event;
use App\Models\Source;
use Exception;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $eventComponent;

    public function __construct(EventComponent $eventComponent)
    {
        parent::__construct();

        $this->eventComponent = $eventComponent;
    }

    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $eventsQuery = $user->events();

        return view('events.index', [
            'events' => $eventsQuery
                ->filter($request->input('f', []))
                ->sortable(['date'])
                ->paginate(),
            'sources' => $user->sources()
                ->withCount('events')
                ->get()
                ->sortByDesc('events_count'),
        ]);
    }

    public function show(Request $request, Event $event)
    {
        return view('events.show', [
            'event' => $event,
        ]);
    }

    public function check(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $messages = [];

        $user->sourcesActive->each(function (Source $source) use (&$messages) {
            try {
                $this->eventComponent->refresh($source);
                $messages[] = [
                    'level' => 'success',
                    'text' => trans('source.update.success', [
                        'source' => $source->title,
                    ]),
                ];
            } catch (Exception $e) {
                $messages[] = [
                    'level' => 'error',
                    'text' => trans('source.update.fail', [
                        'source' => $source->title,
                        'error' => htmlentities($e->getMessage()),
                    ]),
                ];
            }
        });

        return redirect()->action('EventController@index', [
            'f' => [
                'created_at' => [
                    'today',
                ],
            ],
        ])->with([
            'messages' => $messages,
        ]);
    }
}