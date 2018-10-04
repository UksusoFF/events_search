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
    <span class="h3">Sources</span>
    @include('sources.create_edit', [
        'action' => action('SourceController@store'),
        'model' => null,
        'icon' => 'plus',
    ])
    @foreach($sources as $source)
        <div class="text-truncate">
            @include('partials.link_filter', ['params' => [
                'key' => 'sources',
                'value' => $source->id,
                'title' => "{$source->title} ({$source->events_count})",
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

@endsection

@section('content')
    @foreach($tags as $tag)
        @include('partials.link_filter', ['params' => [
            'key' => 'tags',
            'value' => $tag['value'],
            'title' => "${tag['title']} (${tag['count']})",
        ]])
    @endforeach
    @if ($events->count())
        <h2>{{ $events->total() }}</h2>
        {{ $events->appends(request()->except('page'))->links() }}
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Name / Image</th>
                    <th>Source</th>
                    <th class="text-right text-nowrap">@sortablelink('date')</th>
                    <th class="text-right text-nowrap">@sortablelink('created_at')</th>
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
                            <a href="{{ $event->url }}" target="_blank">
                                <img src="{{ $event->image }}" style="max-width: 200px; max-height: 200px;">
                            </a>
                        </td>
                        <td class="text-right">{{ $event->source->title }}</td>
                        <td class="text-right">{{ $event->date->format('Y-m-d H:i:s') }}</td>
                        <td class="text-right">{{ $event->created_at->format('Y-m-d H:i:s') }}</td>
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