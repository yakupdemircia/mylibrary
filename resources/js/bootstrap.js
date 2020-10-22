
window._ = require('lodash');

try {
    require('bootstrap');

    window.Popper = require('popper.js').default;

    window.$ = window.jQuery = require('jquery');

    window.Swal = require('sweetalert2');

    window.moment = require('moment');

    //window.datetimepicker = require('jquery-datetimepicker');

    //require('lightslider');

    //require('lightgallery');

} catch (e) {}

