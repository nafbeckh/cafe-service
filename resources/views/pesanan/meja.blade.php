@extends('layouts.user-template')

@section('content')

<!-- Content Header (Page header) -->
<setion class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{ $title }}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('pesanan.meja') }}">Pemesanan</a></li>
          <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</setion>

<!-- Main content -->
<section class="content">
  <div class="container">
    <div class="row">
      @foreach($meja as $item)
      <a href="{{ $item->status == 'Kosong' ? route('pesanan.menu', $item->id) :  route('pesanan.detail', $item->no_pesanan) }}" class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-{{ $item->status == 'Diisi' ? 'danger' : 'success' }}">
            <div class="inner">
                <h3>Meja {{$item->no_meja}}</h3>
                <p>{{$item->status}}</p>
            </div>
            <div style="margin-top: 7px"><br></div>
        </div>
      </a>
      <!-- ./col -->
      @endforeach
    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection
