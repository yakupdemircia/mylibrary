@extends('frontend.layouts.master')

@section('body-class','page-book-detail')

@section('meta_keywords',trans('strings.meta_keywords'))

@section('content')

    <section class="book-detail-top">
        <div class="content">
            <div class="c-wr">

                <div class="row">
                    <div class="col-md-12">
                        <a class="btn btn-lg btn-info mt-5 float-right" href="{{route_locale('frontend.return-screen')}}">Go to return screen</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Book (name,isbn etc...)</label>
                        <select class="search-book w-100"></select>
                    </div>
                    <div class="col-md-6">
                        <label>User (id,email,name etc...)</label>
                        <select class="search-user w-100"></select>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <label>Rent date</label>
                        <input type="text" id="start_date" class="form-control dpicker" autocomplete="Off" value="{{ date_locale(date('Y-m-d')) }}">
                        <input type="hidden" id="start_date_alt" name="start_date" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-6">
                        <label>Expected return date</label>
                        <input type="text" id="end_date" class="form-control dpicker" autocomplete="Off" value="{{ date_locale(date('Y-m-d',strtotime('+15 days'))) }}">
                        <input type="hidden" id="end_date_alt" name="end_date" value="{{ date('Y-m-d',strtotime('+15 days')) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-lg btn-primary rent-book mt-5 float-right">Rent Book To User</button>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

@push('js')
    <script type="text/javascript">

        $(document).ready(function () {


            $("#start_date").datepicker({
                dateFormat: '{{ trans('globals.date_format_js') }}',
                altFormat: "yy-mm-dd",
                altField: "#start_date_alt",
                changeMonth: true,
                onSelect: function (date) {

                    var selectedDate = new Date(date);
                    var msecsInADay = 86400000;
                    var endDate = new Date(selectedDate.getTime() + msecsInADay);

                    //Set Minimum Date of EndDatePicker After Selected Date of StartDatePicker
                    $("#end_date").datepicker("option", "minDate", endDate);
                    $("#end_date").datepicker("option", "maxDate", '+2m');

                }
            });

            $("#end_date").datepicker({
                dateFormat: '{{ trans('globals.date_format_js') }}',
                altFormat: "yy-mm-dd",
                altField: "#end_date_alt",
                changeMonth: true,
            });

            $(".search-book").select2({
                ajax: {
                    url: "ajax/search-book",
                    dataType: 'json',
                    delay: 250,//debounce 250 miliseconds
                    data: function (params) {
                        return {
                            query: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data.books,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Search using book name, author name or publisher name',
                minimumInputLength: 1,
                templateResult: bookResults,
                templateSelection: bookClicked
            });

            function bookResults(book) {
                if (book.loading) {
                    return book.text;
                }

                var $container = $(
                    '<div class="select2-result-repository clearfix row">' +
                    '<div class="col-md-2"> ' +
                    '   <div class="select2-result-repository__avatar"><img src="' + book.image_url + '" /></div>' +
                    '</div>' +
                    '<div class="col-md-8"> ' +
                    '<div class="book-info">' +
                    '<div class="title"></div>' +
                    '<div class="description"></div>' +
                    '<div> ' +
                    '<div class="category inline" style="display: inline-block;"></div>&nbsp;&nbsp;&nbsp;' +
                    '<div class="publisher inline" style="display: inline-block;"></div>&nbsp;&nbsp;&nbsp;' +
                    '<div class="author inline" style="display: inline-block;"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-2"><a class="rent-book btn btn-primary btn-sm fg-white">Details</a> </div>' +
                    '</div>'
                );

                $container.find(".title").text(book.title);
                $container.find(".description").text(book.description);
                $container.find(".author").append("Author: " + book.author);
                $container.find(".category").append("Category: " + book.category);
                $container.find(".publisher").append("Publisher: " + book.publisher);
                $container.find(".rent-book").attr('href','book-detail/'+book.isbn);

                return $container;
            }

            function bookClicked(book){
                if(typeof book.title === "undefined"){
                    return 'Search using book name, author name or publisher name';
                }
                return book.author + ' | ' + book.title
            }

            $(".search-book").on('select2:select', function (e) {
                $('.search-user').select2('open');
            });

            $(".search-user").select2({
                ajax: {
                    url: "ajax/search-user",
                    dataType: 'json',
                    delay: 250,//debounce 250 miliseconds
                    data: function (params) {
                        return {
                            query: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data.books,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Search using users id, name or email',
                minimumInputLength: 1,
                templateResult: userResults,
                templateSelection: userClicked

            });

            function userResults(user) {
                if (user.loading) {
                    return user.text;
                }

                var $container = $(
                    '<div class="select2-result-repository clearfix row">' +
                    '<div class="col-md-2"> ' +
                    '   <div class="select2-result-repository__avatar"><img src="' + user.image_url + '" /></div>' +
                    '</div>' +
                    '<div class="col-md-10"> ' +
                    '<div class="book-info">' +
                    '<div class="title"></div>' +
                    '<div class="description"></div>' +
                    '<div> ' +
                    '<div class="rented inline" style="display: inline-block;"></div>&nbsp;&nbsp;&nbsp;' +
                    '<div class="delayed inline" style="display: inline-block;"></div>&nbsp;&nbsp;&nbsp;' +
                    '<div class="penalties inline" style="display: inline-block;"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
                );

                $container.find(".title").text(user.name);
                $container.find(".description").text("ID: "+ user.card_id);
                $container.find(".rented").append("Rented Books: " + user.books_in_rent);
                $container.find(".delayed").append("Delayed: "+user.delayed_count);
                $container.find(".penalties").append("Penalties: "+user.penalties);

                return $container;
            }

            function userClicked(user){
                if(typeof user.name === "undefined"){
                    return 'Search using users id, name or email';
                }
                return user.name + ' | ID:' + user.card_id
            }

            $('button.rent-book').click(function () {

                var t = $(this);
                t.attr('disabled','disabled')

                let book_id = $('.search-book').val();
                let user_id = $('.search-user').val();
                let start_date = $('#start_date_alt').val();
                let end_date = $('#end_date_alt').val();


                $.ajax({
                    type: "POST",
                    url: "/ajax/rent-book",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: 'book_id=' + book_id + '&user_id=' + user_id + '&start_date=' + start_date+ '&end_date=' + end_date,
                    success: function (data) {
                        if (data.result === 'success') {
                            Swal.fire('Success', data.message, 'success');
                            setTimeout(function (){
                                window.location.reload();
                            },2000)

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


        });
    </script>
@endpush
