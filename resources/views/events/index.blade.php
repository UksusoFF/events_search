@extends('layout')

@section('sidebar')
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

    <hr>
    <h2>Sources</h2>
    @foreach($sources as $source)
        <div>
            @include('partials.link_filter', ['params' => [
                'key' => 'sources',
                'value' => $source->id,
                'title' => "{$source->title} ({$source->count})",
            ]])

            @include('sources.create_edit', [
                'action' => action('SourceController@update', [
                    'source' => $source['id'],
                ]),
                'model' => $source,
                'icon' => 'pencil',
            ])
        </div>
    @endforeach

    @include('sources.create_edit', [
        'action' => action('SourceController@store'),
        'model' => null,
        'icon' => 'plus',
    ])

    <hr>
    <h2>Tags</h2>
    @foreach($tags as $tag)
        <div>
            @include('partials.link_filter', ['params' => [
                'key' => 'tags',
                'value' => $tag->id,
                'title' => head(explode('|', $tag->name)) . " ({$tag->count})",
            ]])

            @include('tags.create_edit', [
                'action' => action('TagController@update', [
                    'tag' => $tag['id'],
                ]),
                'model' => $tag,
                'icon' => 'pencil',
            ])
        </div>
    @endforeach

    @include('tags.create_edit', [
        'action' => action('TagController@store'),
        'model' => null,
        'icon' => 'plus',
    ])
@endsection

@section('content')
    @if ($events->count())
        <h2>{{ $events->total() }}</h2>
        {{ $events->appends(request()->except('page'))->links() }}
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Name / Image</th>
                    <th class="text-right text-nowrap">@sortablelink('created_at')</th>
                    <th class="text-right text-nowrap">@sortablelink('updated_at')</th>
                    <th class="text-right text-nowrap">@sortablelink('date')</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($events as $event)
                    <tr>
                        <td>
                            <a href="{{ action('EventController@show', $event) }}">
                                {{ $event->title }}
                            </a>
                            <hr>
                            <a href="https://vk.com/event{{ $event->uuid }}">
                                <img src="{{ $event->image }}" style="max-width: 200px; max-height: 200px;">
                            </a>
                        </td>
                        <td class="text-right">{{ $event->created_at->format('Y-m-d H:i:s') }}</td>
                        <td class="text-right">{{ $event->updated_at->format('Y-m-d H:i:s') }}</td>
                        <td class="text-right">{{ $event->date->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $events->appends(request()->except('page'))->links() }}
    @else
        Events not found.
    @endif
@endsection