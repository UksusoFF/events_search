@extends('layout')

@section('content')
    <h1>{{ $events->total() }}</h1>
    @if ($events->count())
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th class="text-right">@sortablelink('created_at')</th>
                    <th class="text-right">@sortablelink('updated_at')</th>
                    <th class="text-right">@sortablelink('start_date')</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($events as $event)
                    <tr onclick="window.open('https://vk.com/event{{ $event->vid }}');">
                        <td>{{ $event->name }}</td>
                        <td><img src="{{ $event->photo_200 }}"></td>
                        <td class="text-right">{{ $event->created_at->format('Y-m-d H:i:s') }}</td>
                        <td class="text-right">{{ $event->updated_at->format('Y-m-d H:i:s') }}</td>
                        <td class="text-right">{{ $event->start_date->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $events->appends(request()->except('page'))->links() }}
    @else
        {{ trans('admin/filters.admin-event-index-empty') }}
    @endif
@endsection