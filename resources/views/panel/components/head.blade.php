@section('head')
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <base href="{{ url('/') }}/">

        <title>Panel</title>

        <meta name="robots" content="noindex,nofollow,noarchive">

        <link rel="stylesheet" href="{{ assets('/css/panel.css') }}">

        @stack('css')

        <script type="text/javascript">
            var _token = '{{ csrf_token() }}';
        </script>

    </head>
@show
