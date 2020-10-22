@extends('panel.layouts.master')

@section('title','Admin Edit')

@section('body')

    <h3 class="head">Admin {{ $head }}</h3>

    <section class="data">

        <form id="form" class="form-horizontal row" action="{{ $route }}" method="POST">

            {{ csrf_field() }}

            <div class="form-group col-sm-12">
                <label for="name">Name</label>
                <input class="form-control" id="name" name="name" value="{{ old('name') ?? $data->name ?? '' }}">
                @include('panel.partial.form-error',['errname'=>'name'])
            </div>

            <div class="form-group col-sm-6">
                <label for="email">Email</label>
                <input class="form-control" id="email" name="email" value="{{ old('email') ?? $data->email ?? '' }}">
                @include('panel.partial.form-error',['errname'=>'email'])
            </div>
            <div class="form-group col-sm-6">
                <label for="password">Password</label>
                <input class="form-control" id="password" name="password">
                <span class="help-block text-info">Leave empty if you don't want to change.</span><br>
                @include('panel.partial.form-error',['errname'=>'password'])
            </div>

            <div class="form-group col-sm-6">
                <label for="phone">Phone</label>
                <input class="form-control" id="phone" name="phone" value="{{ old('phone') ?? $data->phone ?? '' }}">
                @include('panel.partial.form-error',['errname'=>'phone'])
            </div>

            <div class="form-group col-sm-6">
                <label for="bio">Status</label><br>
                <input id="status" name="status"
                       type="checkbox" {{ isset($data->status) ? ($data->status == 1 ? 'checked' : '') :'checked' }}>
            </div>


            <div class="form-group col-sm-12">
                <a class="btn btn-default mw100" href="{{ route('panel.admin.list') }}"><i class="fas fa-backward"></i>
                    List</a>
                <input type="submit" id="submitCreateForm" class="btn btn-primary mw100 float-right" value="Save">
            </div>
        </form>

    </section>

@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {

            var editorElem;

            ClassicEditor
                .create(document.querySelector('#bio'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
                    heading: {
                        options: [
                            {model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph'},
                            {model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1'},
                            {model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2'}
                        ]
                    }
                })
                .then(editor => {
                    editorElem = editor;
                })
                .catch(error => {
                    console.error(error);
                });

            function getDataFromTheEditor() {
                return editorElem.getData();
            }

            $('#submitForm').on('click', function () {
                $(this).addClass('disabled').html('<i class="fa fa-refresh fa-spin"></i>&nbsp;Saving');
            });

            $("#birthday").datepicker({dateFormat: 'yy-mm-dd'});

            $('#status').bootstrapToggle({
                on: 'Active',
                off: 'Passive',
                onstyle: 'success',
                offstyle: 'danger',
            });
        });
    </script>
@endpush

