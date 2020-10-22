@extends('panel.layouts.master')

@section('title','User Edit')

@section('body')

    <h3 class="head">Category {{ $head }}</h3>

    <section class="data">

        <form id="form" class="form-horizontal row" action="{{ $route }}" method="POST">

            {{ csrf_field() }}

            <div class="form-group col-sm-12">
                <label for="name">Name *</label>
                <input class="form-control" id="name" name="name" value="{{ old('name') ?? $data->title ?? '' }}">
                @include('panel.partial.form-error',['errname'=>'title'])
            </div>

            <div class="form-group col-sm-12">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description"
                          rows="5">{{ old('description') ?? $data->description ?? '' }}</textarea>
                @include('panel.partial.form-error',['errname'=>'description'])
            </div>

            <div class="form-group col-sm-12">
                <a class="btn btn-default mw100" href="{{ route('panel.category.list') }}"><i class="fas fa-backward"></i>
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
                .create(document.querySelector('#description'), {
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

        });
    </script>
@endpush
