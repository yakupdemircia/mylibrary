@extends('panel.layouts.master')

@section('title','Author Edit')

@section('body')

    <h3 class="head">Author {{ $head }}</h3>

    <section class="data">

        <form id="form" class="form-horizontal row" action="{{ $route }}" method="POST">

            {{ csrf_field() }}

            <div class="form-group col-sm-12">
                <label for="name">Name *</label>
                <input class="form-control" id="name" name="name" value="{{ old('name') ?? $data->name ?? '' }}">
                @include('panel.partial.form-error',['errname'=>'name'])
            </div>


            <div class="form-group col-sm-12">
                <a class="btn btn-default mw100" href="{{ route('panel.author.list') }}"><i class="fas fa-backward"></i>
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

        });
    </script>
@endpush
