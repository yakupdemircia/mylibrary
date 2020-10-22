var Site = {
    csrf_token: null,
    locale: 'tr',
    isMobile: false,
    scrollStart: false,

    classicEditorOptions: {
        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
        heading: {
            options: [
                {model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph'},
                {model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1'},
                {model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2'}
            ]
        }
    },
    pageFilter: {
        path: null,
        order: null,
        city: null,
    },
    getPageFilters: function () {
        Site.pageFilter.path = window.location.pathname;

        var queryString = window.location.search;
        var urlParams = new URLSearchParams(queryString);
        Site.pageFilter.order = urlParams.get('order')
        Site.pageFilter.city = urlParams.get('city')
    },
    setPageFilters: function () {

        console.log(Site.pageFilter);

        var url = '?';

        if (Site.pageFilter.order) {
            url += 'order=' + Site.pageFilter.order;
        }

        if (Site.pageFilter.city) {
            if (Site.pageFilter.order) {
                url += '&';
            }
            url += 'city=' + Site.pageFilter.city;
        }

        window.location.href = Site.pageFilter.path + url;

    },
    resetPageFilters: function () {
        window.location.href = Site.pageFilter.path;
    },
    deleteRecord: function (button, type, id, return_path) {

        $(button).addClass('loading');

        $.ajax({
            type: "POST",
            data: {
                _token: Site.csrf_token,
                type: type,
                id: id
            },
            url: "/ajax/delete-record",
            dataType: "json",
            success: function (data) {


                if (data.result === 'success') {

                    Swal.fire({
                        title: 'Kayit silindi!',
                        type: 'success',
                    }).then(result => window.location.reload());
                } else {
                    Swal.fire({
                        title: 'Kayit silinemedi!',
                        type: 'error',
                    }).then(result => window.location.reload());

                }

            },
            error: function (error) {

                Swal.fire({
                    title: 'Teknik bir hata oluştu!',
                    type: 'error',
                }).then(result => window.location.reload());


            }
        });
    },
    updateStatus: function (button, type, id, status) {

        $(button).addClass('loading');

        $.ajax({
            type: "POST",
            data: {
                _token: Site.csrf_token,
                type: type,
                id: id,
                status: status
            },
            url: "/ajax/update-status",
            dataType: "json",
            success: function (data) {

                if (data.result === 'success') {

                    Swal.fire({
                        title: 'Yayın durumu değişti',
                        type: 'success',
                    }).then(result => window.location.reload());

                } else {
                    Swal.fire({
                        title: 'Yayın durumu değiştirilemedi',
                        type: 'error',
                    }).then(result => window.location.reload());

                }

            },
            error: function (error) {

                Swal.fire({
                    title: 'Teknik bir hata oluştu!',
                    type: 'error',
                }).then(result => window.location.reload());


            }
        });
    },

    setOuterClick: function () {

        $(document).mouseup(function (e) {

            var hs = $(".home-search");
            if (!hs.is(e.target) && hs.has(e.target).length === 0) {
                $(".home-search .search-result-wr").removeClass('has-result').html('');
                $(".home-search input").val('');
            }

        });

    },
    setSearchBar: function () {

        var to = false;

        $(".home-search input").on('keyup', function () {

            var t = $(this);
            var p = $(".home-search");
            var w = $('.search-result-wr', p);
            var str = t.val(); //.toLowerCase().replace(/[^a-zA-Z0-9 ]/g, '');
            if (to) {
                clearTimeout(to);
            }

            if (str.length > 2) {
                to = setTimeout(function () {

                    p.addClass('loading');

                    $.ajax({
                        type: 'POST',
                        url: 'ajax/search',
                        data: {
                            query: str
                        },
                        dataType: 'json',
                        success: function (response) {

                            console.log(response);
                            p.removeClass('loading');

                            if (response.status === "success") {
                                w.html(response.html);

                                w.addClass('has-result');

                            } else {
                                w.removeClass('has-result');

                                w.html("<br>Sonuç bulunamadı!");
                            }

                        },
                        error: function (error) {
                            p.removeClass('loading');

                            w.removeClass('has-result');
                            w.html('');

                        }
                    });

                }, 500);
            } else {
                w.removeClass('has-result').html('');
            }

        });

    },
    setFavorites: function () {
        $('.button-heart').click(function (e) {

            e.preventDefault();
            var t = $(this);

            if (t.hasClass('open-custom-modal')) {
                return true;
            }

            t.attr('disabled', 'disabled');
            var type = t.data('type');
            var id = t.data('id');
            var process = 'add';

            if (t.hasClass('active')) {
                process = 'remove';
            }

            $.ajax({
                type: "POST",
                url: "/ajax/favorites",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: 'type=' + type + '&item_id=' + id + '&process=' + process,
                success: function (data) {
                    if (data.result === 'success') {
                        if (process === 'add') {
                            t.addClass('active');
                        } else {
                            t.removeClass('active');
                        }
                        t.removeAttr('disabled');

                    } else {
                        alert('An error occurred. Please try again');
                        t.removeAttr('disabled');
                    }
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    alert('An error occurred. Please try again');
                }
            });

        });
    },
    setGlobalButtons: function () {

        $(".hamburger").click(function () {
            $(this).toggleClass('is-active');
            $("header .menu").toggleClass('opened');
            Site.scrollStart = false;
        });

        $(document).on('scroll', function () {

            if (!Site.scrollStart) {
                Site.scrollStart = true;
                $(".hamburger").removeClass('is-active');
                $("header .menu").removeClass('opened');
            }

        })

        $("#btn_send_verification_resend").click(function () {

            var t = $(this);

            t.attr('disabled', 'disabled');

            $.ajax({
                type: 'POST',
                url: 'email/resend',
                dataType: 'json',
                success: function (response) {

                    Swal.fire({
                        icon: response.result,
                        html: response.message,
                    });

                },
                error: function (error) {

                    var data = JSON.parse(error.responseText);

                    console.log(data);

                    Swal.fire({
                        icon: 'error',
                        html: 'Teknik bir hata oluştu!',
                    });
                }
            });

        });

        $('body').on('click', '.delete-event-btn', function () {
            var t = $(this);
            var id = t.data('id');
            var type = t.data('type');
            var rp = t.data('return-path');


            Swal.fire({
                title: "Emin misiniz?",
                text: "Bu kayıt silinecektir!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Evet",
                cancelButtonText: "Hayır",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then((result) => {
                if (result.value) {
                    Site.deleteRecord(t, type, id, rp);
                }
            });

        });
        $('body').on('click', '.update-event-status-btn', function () {
            var t = $(this);
            var id = t.data('id');
            var type = t.data('type');
            var status = t.data('set-status');

            Site.updateStatus(t, type, id, status);

        });

        $('body').on('change', 'select.select-order', function () {
            Site.pageFilter.order = $(this).find('option:selected').attr('value');
            Site.setPageFilters();
        });

        $('.filter-city-selector').on('click', 'li', function () {
            Site.pageFilter.city = $(this).find('a').data('id');
            Site.setPageFilters();
        });
        $('.filter-city-reset').on('click', function () {
            Site.resetPageFilters();
        });

        $('.select2').select2();

    },
    setUploadButtons: function () {
        $(".dZUpload").each(function (index) {

            var t = $(this);
            var f = t.parents('.image-uploader');
            var h = f.find('input.hiddenImage');
            var u = f.find('.preview ul');
            var i = f.find('.preview img');
            var type = t.data('type');
            var dataW = t.data('w');
            var dataH = t.data('h');
            var dataR = t.data('r');
            var dataG = Boolean(t.data('g'));
            var dataN = t.data('n');

            t.dropzone({
                url: '/ajax/upload-image',
                addRemoveLinks: true,
                uploadMultiple: dataG,
                parallelUploads: 1,
                acceptedFiles: '.jpg,.jpeg,.png',
                init: function () {
                    this.on("sending", function (file, xhr, formData) {
                        formData.append('_token', Site.csrf_token);
                        formData.append('type', type);
                    });
                },
                success: function (file, response) {

                    if (response.result === 'success') {
                        file.previewElement.classList.add("dz-success");

                        if (dataG) {

                            var li = $('<li>' +
                                '<img src="' + response.file.full_name + '">' +
                                '<span class="fas fa-trash remove-image"></span>' +
                                '<input type="hidden" name="' + dataN + '[]" class="hiddenImage" value="' + response.file.destination_path + '">' +
                                '</li>');

                            u.append(li);

                        } else {

                            h.val(response.file.destination_path);
                            i.attr('src', response.file.full_name);

                            if (type === "user") {
                                //$(".img-wr.profile.me img").attr('src', response.file.full_name);
                            }

                        }

                        $('.dropzone .dz-preview.dz-image-preview').remove();
                        $('.dropzone.dz-started .dz-message').show();


                    } else {
                        file.previewElement.classList.add("dz-error");
                        h.val('');
                        i.attr('src', '/img/blank.gif');
                    }

                    console.log(response);
                },
                error: function (file, response) {
                    file.previewElement.classList.add("dz-error");
                    h.val('');
                    i.attr('src', '/img/blank.gif');
                    console.log(response);

                },
                transformFile: function (file, done) {

                    var editor = $('<div class="dzupload-cr-wr dzupload-cr-wr-' + index + '">' +
                        '<button class="bt bt-red cc clear-dropzone">Iptal</button>' +
                        '<button class="bt bt-blue cf">Resmi Kırp</button>' +
                        '<img>' +
                        '</div>');

                    $('body').append(editor);

                    var buttonConfirm = $('button.cf', editor);
                    var buttonCancel = $('button.cc', editor);

                    // Create an image node for Cropper.js
                    var image = new Image();
                    image.src = URL.createObjectURL(file);
                    editor.append(image);

                    // Create Cropper.js
                    var cropper = new Cropper(image, {
                        zoomable: false,
                        movable: false,
                        aspectRatio: dataR,
                    });
                    console.log(dataW, dataH, dataR);

                    buttonConfirm.on('click', function () {
                        // Get the canvas with image data from Cropper.js
                        var canvas = cropper.getCroppedCanvas({
                            width: dataW,
                            height: dataH
                        });
                        // Turn the canvas into a Blob (file object without a name)
                        canvas.toBlob(function (blob) {
                            // Return the file to Dropzone
                            done(blob);
                        });
                        // Remove the editor from the view
                        editor.remove();
                    });

                    buttonCancel.on('click', function () {
                        // Remove the editor from the view
                        editor.remove();

                        $('.dz-image-preview', t).remove();
                        $('.dz-message', t).show();
                    });

                },
            });

        });

        $(document).on('click', '.remove-image', function () {


            var t = $(this);
            var p = t.parents('.image-uploader');
            var l = t.parents('li');
            var d = p.find('.dropzone');
            var dataG = Boolean(d.data('g'));
            var h = p.find('#image');
            var i = p.find('.preview img');


            if (dataG) {
                l.remove();
            } else {
                h.val('');
                i.attr('src', '/img/blank.gif');
            }


        });
    },
    openCustomModal: function (type) {

        $(".mdl-layer").removeClass('opened');
        $("body").removeClass('modal-opened');

        if (type && $("." + type + "-modal").length) {
            $("body").addClass('modal-opened');
            $("." + type + "-modal").addClass('opened');
        }
    },
    closeCustomModal: function () {
        $(".mdl-layer").removeClass('opened');
        $("body").removeClass('modal-opened');
    },
    setModals: function () {
        /* modals */

        $(".mdl-layer .mdl-close").click(function () {
            Site.closeCustomModal();
        });

        $("body").on('click', '.open-custom-modal', function (e) {
            e.preventDefault();
            var rel = $(this).attr('data-rel');
            Site.openCustomModal(rel);
        });

        /* modal actions */

        $('.login-modal input').keypress(function (e) {
            if (e.which == 13) {
                $("#btn_modal_login").click();
                return false;
            }
        });

        $('.input-wr.password').on('click', '.show-password', function (e) {
            var t = $(this);
            var p = $('.input-wr.password');
            var x = $('input', p);

            if (x.attr('type') === "password") {
                x.attr('type', 'text');
            } else {
                x.attr('type', 'password');
            }
        });

        $("#btn_modal_login").click(function () {

            var t = $(this);
            var p = t.parents('.login-modal');
            var f = t.parents('form');

            f.submit(function (e) {
                e.preventDefault();
            });


            if (f.validationEngine('validate') === true) {

                t.attr('disabled', 'disabled').addClass('loading');

                $.ajax({
                    type: 'POST',
                    url: '/login',
                    dataType: 'json',
                    data: {
                        email: $("#email", f).val(),
                        password: $("#password", f).val(),
                    },
                    success: function (data) {

                        t.removeAttr('disabled').removeClass('loading');
                        Site.closeCustomModal();

                        console.log(data);

                        Swal.fire({
                            icon: data.result,
                            html: data.message,
                        });

                        window.setTimeout(function () {
                            location.href = "/";
                        }, 1000);


                    },
                    error: function (error) {
                        t.removeAttr('disabled').removeClass('loading');

                        var data = JSON.parse(error.responseText);

                        var errorsTexts = "";

                        if (data.errors.email !== undefined) {
                            $(data.errors.email).each(function (index1, array) {
                                errorsTexts += "<br>* " + data.errors.email[index1];
                            });
                        }

                        if (data.errors.password !== undefined) {
                            $(data.errors.password).each(function (index2, array) {
                                errorsTexts += "<br>* " + data.errors.password[index2];
                            });
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Hata',
                            html: errorsTexts,
                            footer: '<a href>Why do I have this issue?</a>'
                        });

                    }
                });

            }

        });

        $("#btn_modal_signup").click(function () {

            var t = $(this);
            var p = t.parents('.signup-modal');
            var f = t.parents('form');

            f.submit(function (e) {
                e.preventDefault();
            });


            if (f.validationEngine('validate') === true) {

                t.attr('disabled', 'disabled').addClass('loading');

                $.ajax({
                    type: 'POST',
                    url: '/signup',
                    dataType: 'json',
                    data: {
                        "name": $("#name", f).val(),
                        "email": $("#email", f).val(),
                        "password": $("#password", f).val(),
                        "password_confirmation": $("#password", f).val(),
                    },
                    success: function (data) {
                        t.removeAttr('disabled').removeClass('loading');
                        Site.closeCustomModal();


                        console.log(data);

                        if (data.result) {

                            Swal.fire({
                                icon: data.result,
                                html: data.message,
                            });

                            window.setTimeout(function () {
                                location.href = "/";
                            }, 3000);

                        } else {

                            var errorsTexts = "";

                            if (data.email !== undefined) {
                                $(data.email).each(function (index1, array) {
                                    errorsTexts += "<br>* " + data.email[index1];
                                });
                            }

                            if (data.password !== undefined) {
                                $(data.password).each(function (index2, array) {
                                    errorsTexts += "<br>* " + data.password[index2];
                                });
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Hata',
                                html: errorsTexts,
                                footer: '<a href>Why do I have this issue?</a>'
                            });

                        }


                    },
                    error: function (error) {
                        t.removeAttr('disabled').removeClass('loading');

                        var data = JSON.parse(error.responseText);

                        var errorsTexts = "";

                        if (data.errors.email !== undefined) {
                            $(data.errors.email).each(function (index1, array) {
                                errorsTexts += "<br>* " + data.errors.email[index1];
                            });
                        }

                        if (data.errors.password !== undefined) {
                            $(data.errors.password).each(function (index2, array) {
                                errorsTexts += "<br>* " + data.errors.password[index2];
                            });
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Hata',
                            html: errorsTexts,
                            footer: '<a href>Why do I have this issue?</a>'
                        });

                    }
                });

            }

        });

        $("#btn_modal_send_verification").click(function () {

            var t = $(this);
            var p = t.parents('.send-verification-modal');
            var f = t.parents('form');

            f.submit(function (e) {
                e.preventDefault();
            });

            if (f.validationEngine('validate') === true) {

                t.attr('disabled', 'disabled').addClass('loading');

                $.ajax({
                    type: 'POST',
                    url: '/email/resend',
                    dataType: 'json',
                    data: {
                        "email": $("#email", f).val(),
                    },
                    success: function (data) {
                        t.removeAttr('disabled').removeClass('loading');
                        Site.closeCustomModal();

                        $("#alert_send_verification").remove();

                        console.log(data);

                        if (data.result) {

                            Swal.fire({
                                icon: data.result,
                                html: data.message,
                            });

                        } else {

                            var errorsTexts = "";

                            if (data.email !== undefined) {
                                $(data.email).each(function (index1, array) {
                                    errorsTexts += "<br>* " + data.email[index1];
                                });
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Hata',
                                html: errorsTexts,
                                footer: '<a href>Why do I have this issue?</a>'
                            });

                        }


                    },
                    error: function (error) {
                        t.removeAttr('disabled').removeClass('loading');

                        var data = JSON.parse(error.responseText);

                        var errorsTexts = "";

                        if (data.errors.email !== undefined) {
                            $(data.errors.email).each(function (index1, array) {
                                errorsTexts += "<br>* " + data.errors.email[index1];
                            });
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Hata',
                            html: errorsTexts,
                            footer: '<a href>Why do I have this issue?</a>'
                        });

                    }
                });

            }

        });

        $("#btn_reset_password").click(function () {

            var url, data, type;

            var t = $(this);
            var p = t.parents('.reset-password-modal');
            var f = t.parents('form');

            f.submit(function (e) {
                e.preventDefault();
            });

            if (f.validationEngine('validate') === true) {

                t.attr('disabled', 'disabled').addClass('loading');

                if ($("#reset_password", f).length) {

                    type = 1;
                    url = 'password/reset';
                    data = {
                        password: $("#reset_password", f).val(),
                        password_confirmation: $("#reset_password_confirm", f).val(),
                        email: $("#reset_password_email", f).val(),
                        token: $("#reset_password_token", f).val(),
                    };
                } else {
                    type = 2;
                    url = '/password/email';
                    data = {email: $("#email", f).val()};
                }

                $.ajax({
                    type: 'POST',
                    url: url,
                    dataType: 'json',
                    data: data,
                    success: function (data) {
                        t.removeAttr('disabled').removeClass('loading');
                        Site.closeCustomModal();

                        $("#alert_send_verification").remove();

                        console.log(data);

                        Swal.fire({
                            icon: data.result,
                            html: data.message,
                        });

                        if (type === 1) {
                            window.setTimeout(function () {
                                location.href = "/";
                            }, 3000);
                        }

                    },
                    error: function (error) {
                        t.removeAttr('disabled').removeClass('loading');

                        var data = JSON.parse(error.responseText);

                        var errorsTexts = "";

                        if (data.errors.email !== undefined) {
                            $(data.errors.email).each(function (index1, array) {
                                errorsTexts += "<br>* " + data.errors.email[index1];
                            });
                        }
                        if (data.errors.password !== undefined) {
                            $(data.errors.password).each(function (index1, array) {
                                errorsTexts += "<br>* " + data.errors.password[index1];
                            });
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Hata',
                            html: errorsTexts,
                            footer: '<a href>Why do I have this issue?</a>'
                        });

                    }
                });

            }

        });

    },
    afterLoadingPage: function () {

        //datetimepicker set locale
        //$.datetimepicker.setLocale(Site.locale);

        //ajax csrf_token setup
        $.ajaxPrefilter(function (options, originalOptions, jqXHR) {
            //if (options.type.toLowerCase() === "post") {
            // initialize `data` to empty string if it does not exist
            options.data = options.data || "";

            // add leading ampersand if `data` is non-empty
            options.data += options.data ? "&" : "";

            // add _token entry
            options.data += "_token=" + encodeURIComponent(Site.csrf_token);

            //add language entry
            options.data += "&_lang=" + Site.locale;
            //  }
        });

        Site.setModals();
        Site.setGlobalButtons();
        Site.setSearchBar();
        Site.setUploadButtons();
        Site.setOuterClick();
        Site.setFavorites();
        Site.getPageFilters();

    },
    init: function () {

        Site.afterLoadingPage();

    }
};
