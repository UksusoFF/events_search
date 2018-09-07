<?php

namespace App\Http\Controllers;

use App\Components\EventComponent;
use App\Models\Event;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
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

        $messages = [];

        foreach ($user->sources as $source) {
            try {
                $eventComponent->refresh($source);
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
        }

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