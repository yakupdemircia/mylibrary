@extends('frontend.layouts.master')

@section('body-class','page-book-detail')

@section('meta_keywords',trans('strings.meta_keywords'))

@section('content')

    <section class="book-detail-top">
        <div class="content">
            <div class="c-wr">

                <div class="row">
                    <div class="col-md-12">
                        <a class="btn btn-lg btn-info mt-5 mb-5 float-right" href="{{route_locale('frontend.screen')}}">Go to rent screen</a>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <table id="issues_table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Book</th>
                                <th>User</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Return Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($issues as $issue)

                                @php
                                $status = calc_issue_status($issue);
                                @endphp

                                <tr>
                                    <td>{{$issue->book()->title}}</td>
                                    <td>{{$issue->user()->name}}</td>
                                    <td>{{ date_locale($issue->start_date)}}</td>
                                    <td>{{ date_locale($issue->end_date)}}</td>
                                    <td>{{$issue->return_date ? date_locale($issue->end_date):''}}</td>
                                    <td>{{ucwords($status)}}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger delete-issue" data-id="{{$issue->id}}" data-book_id="{{$issue->book_id}}" data-user_id="{{$issue->user_id}}">Delete</button>
                                    @if($status=='waiting')
                                        <button class="btn btn-sm btn-primary return-book" data-book_id="{{$issue->book_id}}" data-user_id="{{$issue->user_id}}">Return</button>
                                        @endif
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

@push('js')
    <script type="text/javascript">

        $(document).ready(function () {

            $('button.return-book').click(function () {

                var t = $(this);
                t.attr('disabled','disabled')

                let book_id = t.data('book_id');
                let user_id = t.data('user_id');


                Swal.fire({
                    title: 'Are you sure?',
                    text: "The book will be marked as returned!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, return it!'
                }).then((result) => {

                    if (result.value === true) {

                        $.ajax({
                            type: "POST",
                            url: "/ajax/return-book",
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: 'book_id=' + book_id + '&user_id=' + user_id,
                            success: function (data) {
                                if (data.result === 'success') {
                                    Swal.fire('Success', data.message, 'success');
                                    setTimeout(function () {
                                        window.location.reload();
                                    }, 2000)

                                } else {
                                    Swal.fire("Error", "An error occurred. Please try again", "error");

                                    t.removeAttr('disabled');
                                }
                            },
                            error: function (jqXhr, textStatus, errorMessage) {
                                Swal.fire("Error", "An error occurred. Please try again", "error");
                            }
                        });
                    }
                })

            });

            $('button.delete-issue').click(function () {

                var t = $(this);
                t.attr('disabled','disabled')

                let id = t.data('id');
                let book_id = t.data('book_id');
                let user_id = t.data('user_id');


                Swal.fire({
                    title: 'Are you sure?',
                    text: "The issue will be deleted",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    if (result.value === true) {

                        $.ajax({
                            type: "POST",
                            url: "/ajax/delete-issue",
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: 'id='+id+'&book_id=' + book_id + '&user_id=' + user_id,
                            success: function (data) {
                                if (data.result === 'success') {
                                    Swal.fire('Success', data.message, 'success');
                                    setTimeout(function () {
                                        window.location.reload();
                                    }, 2000)

                                } else {
                                    Swal.fire("Error", "An error occurred. Please try again", "error");

                                    t.removeAttr('disabled');
                                }
                            },
                            error: function (jqXhr, textStatus, errorMessage) {
                                Swal.fire("Error", "An error occurred. Please try again", "error");
                            }
                        });
                    }
                })

            });


        });
    </script>
@endpush
