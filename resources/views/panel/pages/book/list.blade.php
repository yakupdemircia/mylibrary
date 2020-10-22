@extends('panel.layouts.master')

@section('body')

    <h3 class="head">Book List</h3>

    <section class="data">

        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable_ajax">
            <thead>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Title</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Title</th>
                <th>Actions</th>
            </tr>
            </tfoot>
        </table>
    </section>

@endsection


@push('js')


    <script type="text/javascript">
        var TableDatatablesManaged = function () {

            var langUrl = '/js/datatables-{{ app()->getLocale() }}.json';

            var initTable = function () {
                var table = $('#datatable_ajax');
                table.DataTable({
                    "language": {
                        url: langUrl,
                    },
                    "bStateSave": true,
                    "processing": true,
                    "serverSide": true,
                    "lengthMenu": [[15, 30, 75, -1], [15, 30, 75, "All"]],
                    "pageLength": 15,
                    "pagingType": "full_numbers",
                    "columnDefs": [{
                        "targets": "_all",
                        'orderable': true,
                        "searchable": false,
                    }],
                    "columns": [
                        {"data": "id"},
                        {"data": "category", sortable: false, searchable: true},
                        {"data": "author", sortable: false, searchable: true},
                        {"data": "publisher", sortable: false, searchable: true},
                        {"data": "title", sortable: true, searchable: true},
                        {"data": "action", sortable: false, searchable: false}
                    ],
                    "ajax": {
                        "url": "{{route('panel.book.all')}}?locale={{ app()->getLocale() }}",
                        "dataSrc": "data"
                    },
                    "order": [
                        [0, 'asc']
                    ],
                    searchDelay: 500
                });

            };

            return {

                //main function to initiate the module
                init: function () {
                    if (!$().dataTable) {
                        return;
                    }

                    initTable();
                }
            };
        }();

        $(document).ready(function () {
            TableDatatablesManaged.init();
        });
    </script>

@endpush
