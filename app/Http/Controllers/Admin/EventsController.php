<?php

namespace App\Http\Controllers\Admin;

use \Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Event\DestroyEvent;
use App\Http\Requests\Admin\Event\IndexEvent;
use App\Http\Requests\Admin\Event\StoreEvent;
use App\Http\Requests\Admin\Event\UpdateEvent;
use App\Models\Event;
use Brackets\AdminListing\Facades\AdminListing;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  IndexEvent $request
     * @return Response|array
     */
    public function index(IndexEvent $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Event::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'vid', 'name', 'start_date', 'ignored'],

            // set columns to searchIn
            ['id', 'vid', 'name', 'description', 'photo_200']
        );

        if ($request->ajax()) {
            return ['data' => $data];
        }

        return view('admin.event.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('admin.event.create');

        return view('admin.event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreEvent $request
     * @return Response|array
     */
    public function store(StoreEvent $request)
    {
        // Sanitize input
        $sanitized = $request->validated();

        // Store the Event
        $event = Event::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/events'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/events');
    }

    /**
     * Display the specified resource.
     *
     * @param  Event $event
     * @return Response
     */
    public function show(Event $event)
    {
        $this->authorize('admin.event.show', $event);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Event $event
     * @return Response
     */
    public function edit(Event $event)
    {
        $this->authorize('admin.event.edit', $event);

        return view('admin.event.edit', [
            'event' => $event,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateEvent $request
     * @param  Event $event
     * @return Response|array
     */
    public function update(UpdateEvent $request, Event $event)
    {
        // Sanitize input
        $sanitized = $request->validated();

        // Update changed values Event
        $event->update($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/events'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/events');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DestroyEvent $request
     * @param  Event $event
     * @return Response|bool
     */
    public function destroy(DestroyEvent $request, Event $event)
    {
        $event->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }
}
