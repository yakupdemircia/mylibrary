@section('script')

    <script type="text/javascript" src="{{ assets('/js/app.js') }}"></script>
    <script type="text/javascript" src="{{ assets('/js/site.js') }}"></script>
    <script type="text/javascript" src="js/jquery.validationEngine-{{ app()->getLocale() }}.js"></script>

    <script type="text/javascript">

        Dropzone.autoDiscover = false;

        $.datepicker.setDefaults($.datepicker.regional[ "{{ app()->getLocale() == 'tr' ? 'tr' : 'en-GB'  }}" ]);

        $(document).ready(function () {
            Site.csrf_token = '{{ csrf_token() }}';
            Site.isMobile = {{ \Agent::isMobile() ? 'true' : 'false' }};
            Site.init();
        });
    </script>

    {{--
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/tr_TR/sdk.js#xfbml=1&version=v2.9&appId=";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
--}}

    @stack('js')


    @if(\Session::has('verified'))

        <script type="text/javascript">
            $(document).ready(function () {

                @if(\Session::get('verified') == 1)
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    html: "Email verified successfully",
                });
                @elseif(\Session::get('verified') == 2)
                Swal.fire({
                    icon: 'error',
                    html: "This email is already verified!",
                });
                @endif
            });
        </script>

    @endif

    @if(isset($page_type) && $page_type == 'reset_password_form')
        <script type="text/javascript">
            $(document).ready(function () {

                Site.openCustomModal('reset-password');

            });
        </script>
    @endif

@show
