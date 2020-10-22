@extends('panel.layouts.master')

@section('title','User Edit')

@section('body')

    <h3 class="head">User {{ $head }}</h3>

    <section class="data">

        <form id="form" class="form-horizontal row" action="{{ $route }}" method="POST">

            {{ csrf_field() }}

            <div class="form-group col-sm-12">
                <label for="user_id">User</label>
                <input class="form-control" id="user_id" name="user_id" value="{{ old('user_id') ?? $data->user()->name ?? '' }}" readonly>
                @include('panel.partial.form-error',['errname'=>'user_id'])
            </div>

            <div class="form-group col-sm-12">
                <label for="book_id">Book</label>
                <input class="form-control" id="book_id" name="book_id" value="{{ old('book_id') ?? $data->book()->title ?? '' }}" readonly>
                @include('panel.partial.form-error',['errname'=>'book_id'])
            </div>

            <div class="form-group col-sm-6">
                <label for="start_date">Start Date</label>
                <input class="form-control" id="start_date" name="start_date"
                       value="{{ old('start_date') ?? $data->start_date ? date('Y-m-d',strtotime($data->start_date)) : '' }}">
                @include('panel.partial.form-error',['errname'=>'start_date'])
            </div>

            <div class="form-group col-sm-6">
                <label for="end_date">Start Date</label>
                <input class="form-control" id="end_date" name="end_date"
                       value="{{ old('end_date') ?? $data->end_date ? date('Y-m-d',strtotime($data->end_date)) : '' }}">
                @include('panel.partial.form-error',['errname'=>'end_date'])
            </div>

            <div class="form-group col-sm-6">
                <label for="return_date">Return Date</label>
                <input class="form-control" id="return_date" name="return_date"
                       value="{{ old('return_date') ?? $data->return_date ? date('Y-m-d',strtotime($data->return_date)) :'' }}">
                @include('panel.partial.form-error',['errname'=>'return_date'])
            </div>

            <div class="form-group col-sm-12">
                <a class="btn btn-default mw100" href="{{ route('panel.issue.list') }}"><i class="fas fa-backward"></i>
                    List</a>
                <input type="submit" id="submitCreateForm" class="btn btn-primary mw100 float-right" value="Save">
            </div>
        </form>

    </section>

@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {

            $('#submitForm').on('click', function () {
                $(this).addClass('disabled').html('<i class="fa fa-refresh fa-spin"></i>&nbsp;Saving');
            });

            $("#start_date").datepicker({dateFormat: 'yy-mm-dd'});
            $("#end_date").datepicker({dateFormat: 'yy-mm-dd'});
            $("#return_date").datepicker({dateFormat: 'yy-mm-dd'});

            $('#status').bootstrapToggle({
                on: 'Active',
                off: 'Passive',
                onstyle: 'success',
                offstyle: 'danger',
            });
        });
    </script>
@endpush
