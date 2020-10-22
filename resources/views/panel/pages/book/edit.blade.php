@extends('panel.layouts.master')

@section('title','User Edit')

@section('body')


    <div class="col-sm-6">
        <h3 class="head">Book {{ $head }}</h3>
    </div>
    <div class="col-sm-6">
        <form method="post" action="{{route('panel.book.create')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-row align-items-center">
                <div class="col-auto">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="excel_file" name="excel_file" required>
                            <label class="custom-file-label" for="excel_file">Import From XLS</label>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-warning">Import</button>
                </div>
            </div>
        </form>
    </div>

    <section class="data">

        <form id="form" class="form-horizontal row" action="{{ $route }}" method="POST">

        {{ csrf_field() }}

            <div class="form-group col-sm-6">
                <label for="category_id">Category</label>
                <select class="form-control select2" name="category_id">
                    <option value="">Select or type to create new one</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                                @if(!is_null($data))
                                @if($category->id == $data->category_id)
                                selected
                                @endif
                                @endif
                        >{{ $category->title}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-sm-6">
                <label for="author_id">Author</label>
                <select class="form-control select2" name="author_id">
                    <option value="">Select or type to create new one</option>
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}"
                                @if(!is_null($data))
                                @if($author->id == $data->author_id)
                                selected
                                @endif
                                @endif
                        >{{ $author->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-sm-6">
                <label for="publisher_id">Publisher</label>
                <select class="form-control select2" name="publisher_id">
                    <option value="">Select or type to create new one</option>
                    @foreach($publishers as $publisher)
                        <option value="{{ $publisher->id }}"
                                @if(!is_null($data))
                                @if($publisher->id == $data->publisher_id)
                                selected
                                @endif
                                @endif
                        >{{ $publisher->title}}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group col-sm-12">
                <label for="title">Name *</label>
                <input class="form-control" id="title" name="title" value="{{ old('title') ?? $data->title ?? '' }}">
                @include('panel.partial.form-error',['errname'=>'title'])
            </div>


            <div class="form-group col-sm-6">
                <label for="purchase_date">Purchase Date</label>
                <input class="form-control" id="purchase_date" name="purchase_date"
                       value="{{ old('purchase_date') ?? $data->purchase_date ?? '' }}">
                @include('panel.partial.form-error',['errname'=>'purchase_date'])
            </div>

            <div class="form-group col-sm-6">
                <label for="isbn">ISBN</label>
                <input class="form-control" id="isbn" name="isbn" value="{{ old('isbn') ?? $data->isbn ?? '' }}">
                @include('panel.partial.form-error',['errname'=>'isbn'])
            </div>

            <div class="form-group col-sm-6">
                <label for="edition">Edition</label>
                <input class="form-control" id="edition" name="edition"
                       value="{{ old('edition') ?? $data->edition ?? '' }}">
                @include('panel.partial.form-error',['errname'=>'edition'])
            </div>

            <div class="form-group col-sm-6">
                <label for="cost">Price</label>
                <input class="form-control" type="number" id="cost" name="cost"
                       value="{{ old('cost') ?? $data->cost ?? '' }}">
                @include('panel.partial.form-error',['errname'=>'cost'])
            </div>

            <div class="form-group col-sm-6">
                <label for="stock">Stok</label>
                <input class="form-control" type="number" id="stock" name="stock"
                       value="{{ old('stock') ?? $data->stock ?? '' }}">
                @include('panel.partial.form-error',['errname'=>'stock'])
            </div>

            <div class="form-group col-sm-6">
                <label for="status">Status</label><br>
                <input id="status" name="status"
                       type="checkbox" {{ isset($data->status) ? ($data->status == 1 ? 'checked' : '') :'checked' }}
                       value="1">
            </div>

            <div class="form-group col-sm-12">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description"
                          rows="5">{{ old('description') ?? $data->description ?? '' }}</textarea>
                @include('panel.partial.form-error',['errname'=>'description'])
            </div>

            <div class="form-group col-sm-12">
                @include('panel.components.dropzone',[
                          'dz_title' => 'Image(640x640px)',
                          'dz_name' => 'image',
                          'dz_value' => $data->image ?? '',
                          'dz_type' => 'book',
                          'dz_width' => 640,
                          'dz_height' => 480])
            </div>


            <div class="form-group col-sm-12">
                <a class="btn btn-default mw100" href="{{ route('panel.user.list') }}"><i class="fas fa-backward"></i>
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

            $("#purchase_date").datepicker({dateFormat: 'yy-mm-dd'});

            $('#status').bootstrapToggle({
                on: 'Active',
                off: 'Passive',
                onstyle: 'success',
                offstyle: 'danger',
            });

            $('.select2').select2({
                tags: true
            });
        });
    </script>
@endpush
