@extends('layouts.admin.main')

@section('contents')

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <div id="export_buttons"></div>
                </div>

                <div class="body">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Name</th>
                            <th>Dob</th>
                            <th>Photo</th>
                            <th>Book</th>
                            <th>Profile Link</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Name</th>
                            <th>Dob</th>
                            <th>Photo</th>
                            <th>Book</th>
                            <th>Profile Link</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="csrf_token">{{csrf_token()}}</div>
@stop

@section('page-spec-css')

    <!-- JQuery DataTable Css -->
    <link href="{{url('plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">

@stop

@section('page-spec-js')
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{url('plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{url('plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{url('plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{url('plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{url('plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{url('plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{url('plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{url('plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>

    <script>
        $(function () {

            var formatDate = function (date, showTime) {
                var d = new Date(date);
                var output;
                output = d.getDate() + '-' + d.getMonth() + '-' + d.getFullYear();
                if(showTime)
                {
                    output += ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                }
                return output;
            };

            var dataTable = $('.js-basic-example').DataTable({
                scrollX: 300,
                serverSide: true,
                processing: true,
                searching: true,
                paging: true,
                columnDefs: [
                    { width: 100, targets: [4] }
                ],
                ajax: {
                    url: '/getAllStudents/',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    {
                        data: 'id',
                        render: function (data, type, row) {
                            return row.id;
                        }
                    },
                    {
                        render: function (data, type, row) {
                            return "<button type='button' data-id='" + row.id + "' class='btn btn-primary waves-effect'><i class='material-icons'>mode_edit</i></button>";
                        },
                        orderable: false
                    },
                    {
                        render: function (data, type, row) {
                            return "<button type='button' data-id='" + row.id + "' class='btn bg-red  waves-effect'><i class='material-icons'>delete_forever</i></button>";
                        },
                        orderable: false
                    },
                    {data: 'name'},
                    {
                        data: 'dob',
                        render: function (data) {
                            return formatDate(data);
                        },
                    },
                    {
                        data: 'photo',
                        render: function (data) {
                            return "<img src='" + data + "' class='img-responsive'>";
                        },
                        orderable: false
                    },
                    {data: 'book_title'},
                    {
                        data: 'profile_link',
                        render: function (data) {
                            return "<a target='_blank' href='" + data + "'>Link</a>";
                        },
                    },
                    {
                        data: 'gender',
                        render: function (data) {
                            var d;
                            switch (data) {
                                case 1:
                                    d = 'Male';
                                    break;
                                case 2:
                                    d = 'Female';
                                    break;
                                default:
                                    d = 'N/A';
                            }
                            return d;
                        },
                        orderable: false

                    },
                    {data: 'email'},
                    {data: 'age'},
                    {
                        data: 'created_at',
                        render: function (data) {
                            return data?formatDate(data, true):null;
                        }
                    },
                    {
                        data: 'updated_at',
                        render: function (data) {
                            return data?formatDate(data, true):null;
                        }
                    }
                ]
            });

            var visibleColumns = [0, 3, 4, 6, 7, 8, 9, 10];
            var exportButtons = new $.fn.dataTable.Buttons(dataTable, {
                buttons: [
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: visibleColumns
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        exportOptions: {
                            columns: visibleColumns
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: visibleColumns
                        }
                    }]
            }).container().appendTo($('#export_buttons'));


            exportButtons[0].classList.add('dt-buttons');

        });
    </script>
@stop