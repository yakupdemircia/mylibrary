<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

{{-- HEAD --}}
@include('panel.components.head')

<body>

{{-- HEADER --}}
@include('panel.components.header')

<div class="app-body">

    {{-- SIDEBAR --}}
    @include('panel.components.sidebar')

    <main class="main">

        {{-- BREADCRUMB --}}
        @include('panel.components.breadcrumb')

        {{-- ACTION / FLASH MESSAGES --}}
        @include('panel.components.flash-message')

        {{-- BODY --}}
        @yield('body')

    </main>

</div>

{{-- SCRIPTS --}}
@include('panel.components.scripts')

</body>
</html>