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
      Kosongkan password jika tidak ingin mengganti password!
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
      <form method="POST" action="{{ route('setting.profileUpdate') }}" id="form" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan Nama" required value="{{ auth()->user()->nama }}">
                @error('nama')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="password">Password :</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
              </div>

              <div class="form-group">
                <label for="confirmPassword">Konfirmasi Password :</label>
                <input type="password" name="confirmPassword" class="form-control @error('confirmPassword') is-invalid @enderror" id="confirmPassword" placeholder="Konfirmasi Password">
                @error('password')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="foto">Foto :</label>
                <div class="custom-file">
                  <input type="file" name="foto" class="custom-file-input @error('foto') is-invalid @enderror" id="foto">
                  <label class="custom-file-label" for="foto">Choose file</label>
                </div>
                @error('foto')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                <img src="{{ asset('assets/dist/img') }}/{{ auth()->user()->foto }}" alt="User Profile" width="100px" height="100px">
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

@endpush