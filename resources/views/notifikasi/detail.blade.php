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
                    <li class="breadcrumb-item"><a href="{{ $waiter ? route('pesanan.meja') : route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('notifikasi.index') }}">Notifikasi</a></li>
                    <li class="breadcrumb-item active">{{ $notifikasi->title }}</li>
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
                <h3 class="card-title">{{ $notifikasi->title }}</h3>

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
              <h5>{{ $notifikasi->message }}</h5>

            @if(auth()->user()->hasRole('chef') || $waiter)
                <a href="{{ route('pesanan.detail', '') }}/{{ $notifikasi->no_pesanan }}" class="btn btn-success btn-sm" title="Lihat Pesanan">Lihat Pesanan</a>
            @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</section>
<!-- /.content -->

@endsection
