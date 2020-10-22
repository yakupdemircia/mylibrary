const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js');

mix
    .scripts([
        //'resources/bower/jquery/dist/jquery.min.js',
       // 'resources/bower/jquery-ui/jquery-ui.min.js',
        //'resources/bower/bootstrap/dist/js/bootstrap.min.js',
        //'resources/bower/bootstrap-sweetalert/dist/sweetalert.min.js',
        //'resources/bower/datetimepicker/jquery.datetimepicker.js',
        'resources/js/datedropper.pro.min.js',

        'resources/bower/jquery-ui/jquery-ui.min.js',
        'resources/bower/jquery-ui/ui/i18n/datepicker-tr.js',
        'resources/bower/jquery-ui/ui/i18n/datepicker-en-GB.js',
        'resources/bower/jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.min.js',
        'resources/bower/bootstrap-toggle/js/bootstrap-toggle.min.js',
        'resources/bower/select2/dist/js/select2.js',
        'resources/bower/dropzone/dist/dropzone.js',
        'resources/bower/cropperjs/dist/cropper.min.js',
        'resources/bower/lightslider/src/js/lightslider.js',
        'resources/bower/lightgallery/dist/js/lightgallery.min.js',

        'resources/bower/ckeditor5-build-classic/build/ckeditor.js',
        'resources/bower/validationengine/js/jquery.validationEngine.min.js',
        'resources/bower/intl-tel-input/build/js/intlTelInput-jquery.min.js',

        'resources/bower/jquery.maskedinput/dist/jquery.maskedinput.min.js',
       // 'resources/bower/air-datepicker/dist/js/datepicker.min.js',

        'resources/js/site.js',
    ], 'public/js/site.js')
    .scripts([
        'resources/bower/jquery/dist/jquery.min.js',
        'resources/bower/jquery-ui/jquery-ui.min.js',
        'resources/bower/dat-gui/build/dat.gui.min.js',
        'resources/js/login.js',
    ], 'public/js/login.js')
    .scripts([
        'resources/bower/jquery-ui/jquery-ui.min.js',
        'resources/bower/bootstrap-toggle/js/bootstrap-toggle.min.js',
        'resources/bower/CoreUI-Free-Bootstrap-Admin/Static_Full_Project_GULP/js/app.js',
        'resources/bower/datatables.net/js/jquery.dataTables.min.js',
        'resources/bower/ckeditor5-build-classic/build/ckeditor.js',
        'resources/bower/select2/dist/js/select2.js',
        'resources/bower/dropzone/dist/dropzone.js',
        'resources/bower/cropperjs/dist/cropper.min.js',
        'resources/bower/bootstrap-sweetalert/dist/sweetalert.min.js',
        'resources/js/panel.js',
    ], 'public/js/panel.js')
    .sass('resources/sass/site/site.scss', 'public/css')
    .sass('resources/sass/panel/login.scss', 'public/css')
    .sass('resources/sass/panel/panel.scss', 'public/css')
    .version();
