@extends($waiter ? 'layouts.user-template' : 'layouts.template')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="{{ $waiter ? 'container' : 'container-fluid' }}">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ $waiter ? route('pesanan.meja') : route('pesanan.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="{{ $waiter ? 'container' : 'container-fluid' }}">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Pesanan</h3>

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
                @if($waiter == true)
                  @if($pesanan->status == 'Pesanan Siap')
                  <button class="btn btn-md btn-success mb-3" id="btnSelesai" type="button" title="Selesaikan Pesanan">
                      Selesaikan Pesanan
                  </button>
                  @endif
                  <button class="btn btn-md btn-secondary mb-3" id="btnPrint" type="button">
                    <i class="fas fa-print mr-2"></i>Cetak Bill
                  </button>
                @else
                  @if($pesanan->status == 'Belum Dikonfirmasi')
                  <button class="btn btn-md btn-success mb-3" id="btnKonfirmasi" type="button" title="Konfirmasi Pesanan">
                      Konfirmasi Pesanan
                  </button>
                  @elseif($pesanan->status == 'Dikonfirmasi')
                  <button class="btn btn-md btn-success mb-3" id="btnSiap" type="button" title="Pesanan Telah Siap">
                      Pesanan Telah Siap
                  </button>
                  @endif
                @endif
                <table id="tableData" class="table table-sm table-hover table-responsive table-bordered">
                    <thead>
                        <tr>
                            <th width=40 class="text-center">No</th>
                            <th width=400>Menu</th>
                            <th width=80 class="text-center">Jumlah</th>
                            <th width=200 class="text-right">Harga</th>
                            <th width=200 class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach($pesananDet as $item)
                        <tr>
                            <td class="text-center">{{ $no++ }}.</td>
                            <td>{{ $item->menu->nama_menu }}</td>
                            <td class="text-center">{{ $item->jumlah }}</td>
                            <td class="text-right">{{ $item->menu->harga }}</td>
                            <td class="text-right">Rp{{ format_uang($item->jumlah * $item->menu->harga) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Tota Harga</th>
                            <th class="text-right">Rp{{ format_uang($total) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</section>
<!-- /.content -->

@endsection

@push('js')
<script>
    $('#btnKonfirmasi').click(function() {
    Swal.fire({
      title: 'Are you sure?',
      text: "Ingin mengonfirmasi Pesanan?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes!',
      confirmButtonAriaLabel: 'Thumbs up, Yes!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No',
      cancelButtonAriaLabel: 'Thumbs down',
      padding: '2em'
    }).then(function(result) {
      if (result.value) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          type: "POST",
          url: "{{ route('pesanan.konfirmasi') }}",
          data: {
            no_pesanan: "{{ $pesanan->no_pesanan }}",
          },
          success: function (res) {
            Swal.fire(
              'Success!',
              res.message,
              'success'
            ).then(function () {
              location.reload();
            });
          },
          error: function (res) {
            Swal.fire(
              'Failed!',
              res.message,
              'error'
            )
          }
        });
      }
    });
  });

  $('#btnSiap').click(function() {
    Swal.fire({
      title: 'Are you sure?',
      text: "Pesanan telah siap disajikan?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes!',
      confirmButtonAriaLabel: 'Thumbs up, Yes!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No',
      cancelButtonAriaLabel: 'Thumbs down',
      padding: '2em'
    }).then(function(result) {
      if (result.value) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          type: "POST",
          url: "{{ route('pesanan.siap') }}",
          data: {
            no_pesanan: "{{ $pesanan->no_pesanan }}",
          },
          success: function (res) {
            Swal.fire(
              'Success!',
              res.message,
              'success'
            ).then(function () {
              location.href = "{{ route('pesanan.index') }}";
            });
          },
          error: function (res) {
            Swal.fire(
              'Failed!',
              res.message,
              'error'
            )
          }
        });
      }
    });
  });

  $('#btnSelesai').click(function() {
    Swal.fire({
      title: 'Are you sure?',
      text: "Anda ingin menyelesaikan pesanan?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes!',
      confirmButtonAriaLabel: 'Thumbs up, Yes!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No',
      cancelButtonAriaLabel: 'Thumbs down',
      padding: '2em'
    }).then(function(result) {
      if (result.value) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          type: "POST",
          url: "{{ route('pesanan.selesai') }}",
          data: {
            no_pesanan: "{{ $pesanan->no_pesanan }}",
          },
          success: function (res) {
            Swal.fire(
              'Success!',
              res.message,
              'success'
            ).then(function () {
              location.reload();
            });
          },
          error: function (res) {
            Swal.fire(
              'Failed!',
              res.message,
              'error'
            )
          }
        });
      }
    });
  });

  $('#btnPrint').click(function() {
    let url = "{{ route('pesanan.print',  $pesanan->no_pesanan) }}";
    window.open(url, '_blank');
  });
</script>
@endpush
