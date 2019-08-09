@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                Source: <a href="{{ action('EventController@index', [
                    'f' => [
                        'sources' => [$event->source->id]
                    ]
                ]) }}">
                    {{ $event->source->title }}
                </a><br />
                Title: <a href="{{ $event->url }}" target="_blank">
                    {{ $event->title }}
                </a><br />
                Date: {{ $event->date->format('Y-m-d H:i:s') }}
                <hr>
                <img src="{{ $event->image }}" class="img-fluid">
            </div>
            <div class="col-sm-8">
                @foreach($event->revisionHistory as $history )
                    <li>Changed {{ $history->fieldName() }}</li>
                    {!! Diff::compare($history->oldValue(), $history->newValue())->toHTML() !!}
                @endforeach
            </div>
        </div>
    </div>
@endsection