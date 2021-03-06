<!doctype html>
<html lang="en">
<head>
    <title>{{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ mix('/styles/app.css') }}">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-10">
                @yield('content')
            </div>
            <div class="col-sm-2">
                @auth
                    <div class="text-center">
                        <img src="{{ auth()->user()->avatar }}" class="rounded">
                    </div>
                    <hr>
                @endauth
                @yield('sidebar')
            </div>
        </div>
    </div>
    <script src="{{ mix('/scripts/app.js') }}"></script>
    <script type="text/javascript">
        toastr.options.closeButton = true;
        toastr.options.timeOut = 0;
        toastr.options.extendedTimeOut = 0;
        @foreach(session()->get('messages', []) as $message)
            toastr.{{ $message['level'] }}("{!! str_replace(PHP_EOL, '', nl2br($message['text'])) !!}");
        @endforeach
    </script>
</body>
</html>