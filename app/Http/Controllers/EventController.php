<?php

namespace App\Http\Controllers;

use App\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
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
}