<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

{{-- HEAD --}}
@include('frontend.components.head')

<body class="@yield('body-class')">

{{-- HEADER --}}
@include('frontend.components.header')

{{-- CONTENT --}}
@yield('content')

{{-- FOOTER --}}
@include('frontend.components.footer')

{{-- MODALS --}}
@include('frontend.components.modals')

{{-- SCRIPTS --}}
@include('frontend.components.script')

{{-- FLASH MESSAGES --}}
@include('frontend.components.flash-swal')

</body>
</html>
