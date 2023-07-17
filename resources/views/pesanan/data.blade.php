@extends('layouts.template')

@push('css')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-checkboxes/css/dataTables.checkboxes.css') }}">
@endpush

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data {{ $title }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="" id="formDeleteBatch">
                    <table id="tableData" class="table table-sm table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Pesanan</th>
                                <th>Meja</th>
                                <th>Waiter</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</section>
<!-- /.content -->

@endsection

@push('js')


<!-- DataTables  & Plugins -->
<script src="{{ asset('assets/plugins/custom.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-checkboxes/js/dataTables.checkboxes.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- jquery-validation -->
<script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<script>
    $(document).ready(function() {
        bsCustomFileInput.init();

        var table = $('#tableData').DataTable({
            processing: true,
            serverSide: true,
            rowId: 'id',
            ajax: "{{ route('pesanan.index') }}",
            lengthChange: false,
            "searching": false,
            "ordering": false,
            "stateSave": false,
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<i class="fas fa-arrow-alt-circle-left"></i>',
                    "sNext": '<i class="fas fa-arrow-alt-circle-right"></i>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<i class="fas fa-search"></i>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "lengthMenu": [
                [10, 50, 100, 1000],
                ['10 rows', '50 rows', '100 rows', '1000 rows']
            ],
            "pageLength": 10,
            autoWidth: false,
            columnDefs: [
                {
                    targets: [0, 2, 3, 5],
                    className: "text-center",
                }
            ],
            columns: [
                {
                    title: 'No.',
                    'data': 'id',
                    render: function (data, type, row, meta) {
                        let no = meta.row + meta.settings._iDisplayStart + 1;
                        return no + '.';
                    }
                },
                {
                    data: 'no_pesanan',
                    title: 'No Pesanan'
                },
                {
                    data: 'meja.no_meja',
                    title: 'Meja',
                    render: function (data, type, row, meta) {
                        return `Meja ${data}`;
                    }
                },
                {
                    data: 'waiter.nama',
                    title: 'Waiter'
                },
                {
                    data: 'status',
                },
                {
                    title: 'Aksi',
                    "data": 'no_pesanan',
                    render: function(data, type, row, meta) {
                        let text = `<div class="btn-group">
                        <a href="{{ route('pesanan.detail', '') }}/${data}" class="btn btn-xs bg-gradient-warning"><i class="fas fa-eye text-white" data-toggle="tooltip" data-placement="top" title="Lihat Detail"></i></a>`;
                        return text;
                    }
                }
            ],
            "stripeClasses": [],
            initComplete: function() {
                $('#tableData').DataTable().buttons().container().appendTo('#tableData_wrapper .col-md-6:eq(0)');
            }
        });

        multiCheck(table);
    });

    $('#tableData').on('click', 'tbody td', function() {

        // console.log('TD cell textContent : ', this.textContent)

    });
    
</script>

@endpush