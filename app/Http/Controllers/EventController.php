<?php

namespace App\Http\Controllers;

use App\Components\EventComponent;
use App\Event;
use App\EventCheckMark;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        return view('events.index', [
            'events' => Event::where('start_date', '>=', Carbon::now())
                ->filter($request->input('f', []))
                ->sortable(['start_date'])
                ->paginate(),
            'tags' => auth()->user()->tags,
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

        return redirect()->action('EventController@index')->with([
            'message' => $result,
        ]);
    }
}