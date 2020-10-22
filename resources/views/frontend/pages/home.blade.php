@extends('frontend.layouts.master')

@section('body-class','page-home')

@section('meta_keywords',trans('strings.meta_keywords'))

@section('content')

    @if(\Auth::check())
        <section>
            <div class="content">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <select class="main-search-select" style="width: 100%;"></select>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </section>
    @else
        <div class="content text-center">
            <p>Please login or register to search books</p>
        </div>
    @endif

@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".main-search-select").select2({
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
                minimumInputLength: 3,
                templateResult: formatResults,
                //templateSelection: bookClicked
            });

            function formatResults(book) {
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
            $(".main-search-select").on('select2:select', function (e) {
                window.location.href = '/book-detail/'+e.params.data.isbn;
            });
        });
    </script>
@endpush
