<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ url('/') }}/">
    <title>{{ config('app.name', 'Dashboard') }}</title>

    <link rel="stylesheet" href="{{ assets('/css/login.css') }}">

    @stack('css')

    <script>
        var csrf_token = "{{ csrf_token() }}";
        var isMobile = {{ Agent::isMobile() ? "true":"false" }};
    </script>

</head>
<body>

@yield('body')

    <script src="{{ assets('/js/login.js') }}"></script>


@stack('js')

</body>
</html>