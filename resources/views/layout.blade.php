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
        @if(session()->has('message'))
            <div class="alert alert-{{ session()->get('message')['success'] ? 'success' : 'danger' }}" role="alert">
                {{ session()->get('message')['text'] }}
            </div>
        @endif
        <div class="row">
            <div class="col-sm-2">
                <div class="text-center">
                    <img src="{{ auth()->user()->avatar }}" class="rounded">
                </div>
                <hr>
                @yield('sidebar')
            </div>
            <div class="col-sm-10">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ mix('/scripts/app.js') }}"></script>
</body>
</html>