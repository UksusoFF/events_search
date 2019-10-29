@component('mail::message')

{{ $text }}

@foreach($events as $event)
    {{ $event->title }}
    {{ $event->url }}
@endforeach

@component('mail::button', ['url' => '123'])
    View Order
@endcomponent

@endcomponent