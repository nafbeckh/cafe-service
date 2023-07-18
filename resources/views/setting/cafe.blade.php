@extends('layouts.template')

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
    <div class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      *Pelanggan yang menggunakan <b>Kode Pelanggan</b> ketika memesan akan mendapatkan diskon beberapa persen dari total pesanannya<br>
      Jika sudah mencapai jumlah pesanan sesuai dengan <b>Per Pesanan</b> yang ditentukan
    </div>
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Form {{ $title }}</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <form method="POST" action="{{ route('setting.cafe.update') }}" id="form" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nama_cafe">Nama Cafe :</label>
                <input type="text" name="nama_cafe" id="nama_cafe" class="form-control @error('nama_cafe') is-invalid @enderror" placeholder="Masukkan Nama Cafe" value="{{ $cafe->nama_cafe }}" required minlength="3" maxlength="25">
                @error('nama_cafe')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
              </div>
              
              <div class="form-group">
                <label for="alamat">Alamat :</label>
                <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="Masukkan Alamat">{{ $cafe->alamat }}</textarea>
                @error('alamat')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group row">
                <div class="col-sm-3">
                  <label for="diskon">Diskon :</label>
                  <div class="input-group mb-3">
                    <input type="text" name="diskon" id="diskon" value="{{ $cafe->diskon }}" class="form-control @error('diskon') is-invalid @enderror" placeholder="0">
                    <div class="input-group-append">
                      <span class="input-group-text">%</span>
                    </div>
                  </div>
                  @error('diskon')
                  <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-sm-3">
                  <label for="per_pesanan">Per Pesanan :</label>
                  <div class="input-group mb-3">
                    <input type="text" name="per_pesanan" id="per_pesanan" value="{{ $cafe->per_pesanan }}" class="form-control col @error('per_pesanan') is-invalid @enderror" placeholder="0">
                    <div class="input-group-append">
                      <span class="input-group-text">X</span>
                    </div>
                  </div>
                  @error('per_pesanan')
                  <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="logo">Logo :</label>
                <div class="custom-file">
                  <input type="file" name="foto" class="custom-file-input @error('foto') is-invalid @enderror" id="foto">
                  <label class="custom-file-label" for="foto">Choose file</label>
                </div>
                @error('foto')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                <img src="{{ asset('assets/dist/img') }}/{{ $cafe->path_logo }}" alt="Logo Toko" width="100px" height="100px">
              </div>           
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary float-right">Simpan</button>
        </div>
        <!-- /.card-footer -->
      </form>
    </div>
    <!-- /.card -->
  </div>
  <!-- /.container-fluid -->
</section>
@endsection

@push('js')
<!-- bs-custom-file-input -->
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

@if(session()->has('success'))
<script>
    Swal.fire(
        'Success',
        "{{ session('success') }}",
        'success'
    )
</script>
@elseif(session()->has('error'))
<script>
    Swal.fire(
        'Failed!',
        "{{ session('error') }}",
        'error'
    )
</script>
@endif
<script>
    $(document).ready(function() {
        bsCustomFileInput.init();
    })
</script>
@endpush