<?php

namespace App\Http\Controllers;

use App\Components\EventComponent;
use App\Models\Event;
use App\Models\Source;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

        return view('events.index', [
            'events' => $user->events()
                ->whereDate('date', '>=', Carbon::now())
                ->filter($request->input('f', []))
                ->sortable(['date'])
                ->paginate(),
            'sources' => $user->sources()
                ->with('tags')
                ->withCount(['events' => function (Builder $query) use ($request) {
                    $query->whereDate('date', '>=', Carbon::now())
                        ->filter($request->input('f', []));
                }])
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
                        'error' => $e->getMessage(),
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