@extends('panel.layouts.master')

@section('body')

    <h3 class="head">Category List</h3>

    <section class="data">

        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable_ajax">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>ID</th>
                <th>Name</th>
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
                        {"data": "title", "title": "translations.title", sortable: true, searchable: true},
                        {"data": "action", sortable: false, searchable: false}
                    ],
                    "ajax": {
                        "url": "{{route('panel.category.all')}}?locale={{ app()->getLocale() }}",
                        "dataSrc": "data"
                    },
                    "order": [
                        [0, 'asc']
                    ]
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
