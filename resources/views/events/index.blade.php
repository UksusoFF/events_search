@extends('layout')

@section('content')
    <h1>{{ $events->total() }}</h1>
    @if ($events->count())
        <div class="pull-right">
            <span class="badge badge-info">Mark all as read</span>
        </div>
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
        {{ $events->appends(request()->except('page'))->links() }}
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th class="text-right">@sortablelink('created_at')</th>
                    <th class="text-right">@sortablelink('updated_at')</th>
                    <th class="text-right">@sortablelink('start_date')</th>
                    <th class="text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($events as $event)
                    <tr>
                        <td>{{ $event->name }}</td>
                        <td>
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
        {{ $events->appends(request()->except('page'))->links() }}
    @else
        {{ trans('admin/filters.admin-event-index-empty') }}
    @endif
@endsection