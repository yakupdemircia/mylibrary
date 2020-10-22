var Panel = {
    csrf_token: null,
    classicEditorOptions : {
        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
        heading: {
            options: [
                {model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph'},
                {model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1'},
                {model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2'}
            ]
        }
    },

    delete_record: function (button, type, id, return_path) {

        $(button).addClass('loading');

        $.ajax({
            type: "POST",
            data: {
                _token: _token,
                type: type,
                id: id
            },
            url: "/panel/ajax/delete-record",
            dataType: "json",
            success: function (data) {


                if (data.result === 'success') {

                    swal({
                            title: 'Kayit silindi!',
                            type: 'success',
                        },
                        function () {

                            $(button).parents('tr').remove();

                        });
                } else {
                    swal({
                            title: 'Kayit silinemedi!',
                            type: 'error',
                        },
                        function () {
                            location.reload();
                        });
                }

            },
            error: function (error) {

                swal({
                        title: 'Teknik bir hata oluştu!',
                        type: 'error',
                    },
                    function () {
                        location.reload();
                    });

            }
        });
    },
    updateStatus: function (button, type, id, status) {

        $(button).addClass('loading');

        $.ajax({
            type: "POST",
            data: {
                _token: _token,
                type: type,
                id: id,
                status: status
            },
            url: "/panel/ajax/update-status",
            dataType: "json",
            success: function (data) {

                if (data.result === 'success') {

                    swal({
                        title: 'Status changed!',
                        type: 'success',
                    });
                } else {
                    swal({
                            title: 'Status not changed!',
                            type: 'error',
                        },
                        function () {
                            location.reload();
                        });
                }

            },
            error: function (error) {

                swal({
                        title: 'Teknik bir hata oluştu!',
                        type: 'error',
                    },
                    function () {
                        location.reload();
                    });

            }
        });
    },
    component_add_day: function (ul) {

        var c = ul.children().length + 1;

        var day = $('<li>' +
            '<div class="edpm-list-item-head">' +
            '<input type="text" value="' + c + '.gün">' +
            '<span class="edpm-add-item">Program Ekle <i class="fa fa-plus"></i></span>' +
            '<span class="edpm-remove-day"><i class="fa fa-trash"></i></span>' +
            '</div>' +
            '<dl></dl>' +
            '</li>');

        ul.append(day.clone());

    },
    set_component_edpm: function () {

        $('.event-daily-program-matic').each(function () {

            var wr = $(this);
            var ls = $('.edpm-list', wr);
            var ul = $('ul', ls);

            $(".edpm-add-day", wr).click(function () {
                Panel.component_add_day(ul);
            });

            wr.on('click', '.edpm-remove-day', function () {
                var t = $(this);
                var p = t.parents('li');
                p.remove();
            });
            wr.on('click', '.edpm-remove-item', function () {
                var t = $(this);
                var p = t.parents('dt');
                p.remove();
            });

        });

    },
    set_action_buttons: function () {

        $('body').on('click', '.delete-btn', function () {
            var t = $(this);
            var id = t.data('id');
            var type = t.data('type');
            var rp = t.data('return-path');

            swal({
                    title: "Emin misiniz?",
                    text: "Bu kayıt silinecektir!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Evet",
                    cancelButtonText: "Hayır",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {

                        Panel.delete_record(t, type, id, rp);
                        //swal("Silindi!", "Kaydınız silindi.", "success");
                    } else {
                        swal("İptal Edildi", "", "error");
                    }
                });

            console.log(id, type, rp);

        });

        $('.menu-wrapper').on('click', function () {
            $("html, body").stop().animate({scrollTop: 0}, 0);
            $('.hamburger-menu').toggleClass('animate');
            $('body, .sidebar').toggleClass('side-menu-opened');
        });

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
                        formData.append('_token', Panel.csrf_token);
                        formData.append('type', type);
                    });
                },
                success: function (file, response) {

                    if (response.result === 'success') {
                        file.previewElement.classList.add("dz-success");

                        if(dataG){

                            var li = $('<li>' +
                                '<img src="'+response.file.full_name+'">' +
                                '<span class="fas fa-trash remove-image"></span>' +
                                '<input type="hidden" name="'+dataN+'[]" class="hiddenImage" value="'+response.file.destination_path+'">' +
                                '</li>');

                            u.append(li);

                        }else{

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


            if(dataG){
                l.remove();
            }else{
                h.val('');
                i.attr('src', '/img/blank.gif');
            }



        });
    },
    set_third_party_components: function () {

        $('.select2').select2();

        //Panel.set_component_edpm();

    },
    init: function () {

        Panel.set_action_buttons();
        Panel.setUploadButtons();
        Panel.set_third_party_components();


    }
};
