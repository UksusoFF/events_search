@extends('layout')

@section('content')
    <div class="row">
        <div class="col-sm-2">
            <h2>{{ $events->total() }}</h2>
            <a href="{{ action('EventController@check') }}" class="btn btn-info">Run check</a>
            @include('partials.link_filter', ['params' => [
                'key' => 'created_at',
                'value' => 'today',
                'title' => 'Created at today',
            ]])
            @include('partials.link_filter', ['params' => [
                'key' => 'updated_at',
                'value' => 'today',
                'title' => 'Updated at today',
            ]])
            @include('partials.link_filter', ['params' => [
                'key' => 'state',
                'value' => 'unread',
                'title' => 'Unread',
            ]])
            <hr>
            @foreach($tags as $tag)
                <div>
                    @include('partials.link_filter', ['params' => [
                        'key' => 'search',
                        'value' => $tag->name,
                        'title' => head(explode('|', $tag->name)),
                    ]])

                    @include('events.tag_create_edit', [
                        'action' => action('TagController@update', [
                            'tag' => $tag
                        ]),
                        'id' => "edit-$tag->id",
                        'tagName' => $tag->name,
                        'icon' => 'pencil',
                    ])
                </div>
            @endforeach

            @include('events.tag_create_edit', [
                'action' => action('TagController@store'),
                'id' => 'create',
                'tagName' => '',
                'icon' => 'plus',
            ])
        </div>
        <div class="col-sm-10">
            @if(session()->has('message'))
                <div class="alert alert-{{ session()->get('message')['success'] ? 'success' : 'danger' }}" role="alert">
                    {{ session()->get('message')['text'] }}
                </div>
            @endif
            {{ $events->appends(request()->except('page'))->links() }}
            @if ($events->count())
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Name / Image</th>
                            <th class="text-right text-nowrap">@sortablelink('created_at')</th>
                            <th class="text-right text-nowrap">@sortablelink('updated_at')</th>
                            <th class="text-right text-nowrap">@sortablelink('start_date')</th>
                            <th class="text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td>
                                    <a href="{{ action('EventController@show', $event) }}">
                                        {{ $event->name }}
                                    </a>
                                    <hr>
                                    <a href="https://vk.com/event{{ $event->vid }}">
                                        <img src="{{ $event->photo_200 }}">
                                    </a>
                                </td>
                                <td class="text-right">{{ $event->created_at->format('Y-m-d H:i:s') }}</td>
                                <td class="text-right">{{ $event->updated_at->format('Y-m-d H:i:s') }}</td>
                                <td class="text-right">{{ $event->start_date->format('Y-m-d H:i:s') }}</td>
                                <td class="text-right">
                                    <a href="{{ action('EventController@read', $event) }}" class="btn btn-success btn-sm" title="Mark as read">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                Events not found.
            @endif
            {{ $events->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endsection