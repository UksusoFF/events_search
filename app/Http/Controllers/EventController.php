<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventCheckMark;
use Artisan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('events.index', [
            'events' => Event::where('start_date', '>=', Carbon::now())
                ->filter($request->input('f', []))
                ->sortable(['created_at'])
                ->paginate(),
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

    public function check(Request $request)
    {
        Artisan::call('events:check');

        return redirect()->action('EventController@index');
    }
}