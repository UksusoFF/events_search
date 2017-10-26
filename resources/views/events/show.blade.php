@extends('layout')

@section('content')
    @foreach($event->revisionHistory as $history )
        <li>Changed {{ $history->fieldName() }}</li>
        {!! Diff::compare($history->oldValue(), $history->newValue())->toHTML() !!}
    @endforeach
@endsection