<script src="{{ assets('/js/app.js') }}"></script>
<script src="{{ assets('/js/panel.js') }}"></script>

<script type="text/javascript">

    Dropzone.autoDiscover = false;

    $.datepicker.setDefaults($.datepicker.regional[ "{{ app()->getLocale() == 'tr' ? 'tr' : 'en-GB'  }}" ]);

    $(document).ready(function () {
        Panel.csrf_token = '{{ csrf_token() }}';
        Panel.init();
    });
</script>

@stack('js')



