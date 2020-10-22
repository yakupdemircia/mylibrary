@if ($message = session()->get('success'))
    <script type="text/javascript">
        $(document).ready(function () {
            Swal.fire({
                icon: 'success',
                html: "{{ $message }}",
            });
        });
    </script>
@endif

@if ($message = session()->get('error'))
    <script type="text/javascript">
        $(document).ready(function () {
            Swal.fire({
                icon: 'error',
                html: "{{ $message }}",
            });
        });
    </script>
@endif

@if ($message = session()->get('warning'))
    <script type="text/javascript">
        $(document).ready(function () {
            Swal.fire({
                icon: 'warning',
                html: "{{ $message }}",
            });
        });
    </script>
@endif

@if ($message = session()->get('info'))
    <script type="text/javascript">
        $(document).ready(function () {
            Swal.fire({
                icon: 'info',
                html: "{{ $message }}",
            });
        });
    </script>
@endif

@if ($errors->any())
    <script type="text/javascript">
        $(document).ready(function () {
            Swal.fire({
                icon: 'warning',
                html: "Bazı hatalar oluştu",
            });
        });
    </script>
@endif
