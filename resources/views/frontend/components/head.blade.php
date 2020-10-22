@section('head')
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <base href="{{ env('APP_URL') }}/">

        {{-- title, description, keywords ---}}
        <title>@yield('title', trans('strings.meta_title'))</title>
        <meta name="description" content="@yield('description', trans('strings.meta_description'))">
        @hasSection('meta_keywords')
            <meta name="keywords" content="@yield('meta_keywords')">
        @endif

        <meta name="robots" content="noindex,nofollow"/>

        @hasSection('meta_next')
            <link rel="next" href="@yield('meta_next')">
        @endif
        @hasSection('meta_prev')
            <link rel="prev" href="@yield('meta_prev')">
        @endif
        @hasSection('meta_canonical')
            <link rel="canonical" href="@yield('meta_canonical')">
        @endif

        {{-- facebook --}}
        <meta property="og:locale" content="tr_TR"/>
        {{--<meta property="og:locale:alternate" content="en_US"/>
        <meta property="og:locale:alternate" content="de_DE"/>
        <meta property="og:locale:alternate" content="ar_SA"/>--}}
        <meta property="og:title" content="{{ trans('strings.meta_title') }}"/>
        <meta property="og:description" content="{{ trans('strings.meta_description') }}"/>
        <meta property="og:url" content="{{ url()->current() }}"/>
        <meta property="og:site_name" content=""/>
        <meta property="og:image" content="{{ trans('strings.meta_image') }}"/>
        <meta property="og:image:width" content="600"/>
        <meta property="og:image:height" content="310"/>

        {{--@include('partials.frontend.hreflang')--}}
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

        @stack('meta')

        <link rel="stylesheet" href="{{ assets('/css/site.css') }}">

        @stack('css')

    </head>
@show
