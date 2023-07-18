@extends('layouts.template')

@push('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-checkboxes/css/dataTables.checkboxes.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
<style>
    .daterangepicker td.in-range {
        background-color: #7ffaf0;
    }

    .daterangepicker td.active,
    .daterangepicker td.active:hover {
        background-color: #357ebd;
    }
</style>
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
                <div class="form-group row">
                    <label for="pilihan" class="col-sm-2 col-form-label">Pilih Periode :</label>
                    <div class="col-sm-3">
                        <select class="form-control" id="pilihan" autocomplete="off">
                            <option value="Hari ini">Hari ini</option>
                            <option value="Minggu ini">Minggu ini</option>
                            <option value="Bulan ini">Bulan ini</option>
                            <option value="Kostum">Kostum Tanggal</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row" id="kostumTanggal" hidden>
                    <label for="tanggal" class="col-sm-2 col-form-label">Periode :</label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" id="tanggal">
                            <span class="input-group-append">
                                <button type="button" id="btnPeriode" class="btn btn-info btn-flat"><i class="fa fa-arrow-right"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-3">
                        <input type="text" id="awal" hidden>
                        <input type="text" id="akhir" hidden>
                        <button type="button" id="btnPrint" class="btn btn-secondary btn-sm" title="Cetak Laporan">Cetak Laporan</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table" class="table table-sm table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center dt-no-sorting">No</th>
                                <th>Tgl Pesanan</th>
                                <th>No Pesanan</th>
                                <th>Waiter</th>
                                <th>Total Item</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        {{-- <tfoot>
                            <tr>
                                <th colspan="3" rowspan="3"></th>
                                <th>Total Penjualan</th>
                                <td id="totalPenjualan">0</td>
                            </tr>
                            <tr class="text-center">
                                <th>Total Pengeluaran</th>
                                <td id="totalPengeluaran">0</td>
                            </tr>
                            <tr class="text-center">
                                <th>Total Pendapatan</th>
                                <td id="totalPendapatan">0</td>
                            </tr>
                        </tfoot> --}}
                    </table>
                </div>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>
</section>

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
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
{{-- <script src="{{ asset('assets/function.js') }}"></script> --}}
<!-- date-range-picker -->
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script>
    function dateFormat(date) {
        return moment(date).format("DD/MM/YYYY HH:mm:ss")
    }

    function hrg(x) {
        let a = parseInt(x)
        return a.toLocaleString('id-ID')
    }

    $('#btnPrint').click(function() {
        let awal = $('#awal').val();
        let akhir = $('#akhir').val();

        let url = `{{ route('laporan.print') }}?awal=${awal}&akhir=${akhir}`;
        window.open(url, '_blank');
    });
    
    $(document).ready(function() {
        $('#tanggal').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD',
                separator: " sampai "
            },
            startDate: moment().subtract(0, 'd').format("YYYY-MM-DD"),
        }).on('change', function() {
            let start = $(this).data('daterangepicker').startDate.format('YYYY-MM-DD')
            let end = $(this).data('daterangepicker').endDate.format('YYYY-MM-DD')

            $('#awal').val(start);
            $('#akhir').val(end);

            getData(start, end);

        })

        $('#pilihan').change(function (){
            $('#kostumTanggal').attr('hidden', true);
            let awal = '';
            let akhir = '';

            if (this.value == 'Hari ini') {
                awal = "{{date('Y-m-d')}}";
                akhir = "{{date('Y-m-d')}}";
            } else if (this.value == 'Minggu ini') {
                awal = "{{date('Y-m-d', strtotime('-7 day'))}}";
                akhir = "{{date('Y-m-d')}}";
            } else if (this.value == 'Bulan ini') {
                awal = "{{date('Y-m-01')}}";
                akhir = "{{date('Y-m-t')}}";
            } else if (this.value == 'Kostum') {
                $('#kostumTanggal').attr('hidden', false);
            }

            $('#awal').val(awal);
            $('#akhir').val(akhir);

            getData(awal, akhir);
        })

        $('#tanggal').change();
    })

    var table = $('#table').DataTable({
        info: false,
        paging: false,
        searching: false,
        lengthchange: false,
        ordering: false,
        autoWidth: true,
        columnDefs: [{
                targets: [0, 4],
                className: "text-center",
            },
            {
                targets: 0,
                width: "30px",
            },
            {
                targets: 4,
                width: "80px",
            },
            {
                targets: 5,
                className: "text-right",
            }
        ],
        columns: [{
                render: function(data, type, row, meta) {
                return parseInt(meta.row) + parseInt(meta.settings._iDisplayStart) + 1;
                }
            },
            {
                data: 'tgl_pesanan',
                title: "Tgl Pesanan",
                render: function(data, type, row, meta) {
                    return dateFormat(data)
                }
            },
            {
                data: 'no_pesanan',
                title: "No Pesanan",
            },
            {
                data: 'waiter',
                title: "Waiter",
            },
            {
                data: 'total_item',
                title: "Total Item",
            },
            {
                data: 'total_harga',
                title: "Total Harga",
                render: function(data, type, row, meta) {
                    return 'Rp' + hrg(data)
                }
            },
        ]
    })

    function getData(awal, akhir) {
        $.ajax({
            type: "GET",
            url: "{{ route('laporan.pesanan') }}",
            data: {
                awal: awal,
                akhir: akhir
            },
            success: function (res) {
                table.clear();
                table.rows.add(res.data).draw();
            },
            error: function (data) {
                console.log('Error:', data);
                Swal.fire('Failed!', 'Server Error', 'error')
            }
        });
    }
</script>
@endpush