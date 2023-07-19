<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/dist/img') }}/{{ $cafe->path_logo }}" />
    <title>{{ $cafe->nama_cafe }} | {{ $title }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    @stack('css')
  </head>
  <body class="hold-transition layout-top-nav">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
      <div class="container">
        <a href="{{ route('pesanan.meja') }}" class="navbar-brand">
          <img src="{{ asset('assets/dist/img') }}/{{ $cafe->path_logo }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">{{ $cafe->nama_cafe }}</span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
          <!-- Left navbar links -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a href="#" class="nav-link" data-toggle="modal" data-target="#modalPelanggan">Daftar Pelanggan</a>
            </li>
          </ul>

          <!-- Right navbar links -->
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="#" data-toggle="modal" data-target="#modalCart">
                  <i class="fas fa-shopping-cart"></i>
                  <span class="badge badge-primary navbar-badge total-count"></span>
              </a>
            </li>
            <li class="nav-item dropdown" id="btnNotif">
              <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge" data-count="" id="counterNotif"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="fetchNotf">
                <div id="fetchNotif">
                  
                </div>
                <a href="" class="dropdown-item dropdown-footer">Lihat Semua Notifikasi</a>
              </div>
            </li>
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('assets/dist/img') }}/{{ auth()->user()->foto }}" class="user-image img-circle elevation-2" alt="User Image">
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                  <img src="{{ asset('assets/dist/img') }}/{{ auth()->user()->foto }}" class="img-circle elevation-2" alt="User Image">

                  <p>
                    {{ auth()->user()->nama }}
                    <small>Terdaftar pada {{ date('M Y', strtotime(auth()->user()->created_at)) }}</small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <a href="{{ route('setting.profile') }}" class="btn btn-default btn-flat">Profile</a>
                  <a href="javascript:void(0);" onclick="logout_()" class="btn btn-default btn-flat float-right">Log out</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>

      </div>
    </nav>
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <div class="modal animated fade fadeInDown" id="modalPelanggan" role="dialog" aria-labelledby="modalPelanggan" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tambah Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" data-toggle="tooltip" title="Close">&times;</span>
                </button>
            </div>
            <form id="form" action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group row">
                            <label for="kode_pelanggan" class="col-sm-3 col-form-label">Kode Pelanggan :</label>
                            <div class="col-sm-9">
                                <input type="text" name="kode_pelanggan" class="form-control" id="kode_pelanggan" placeholder="Masukkan Kode Pelanggan" minlength="6" maxlength="12" required>
                                <span id="err_kode_pelanggan" class="error invalid-feedback" style="display: hide;"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                          <label for="nama" class="col-sm-3 col-form-label">Nama Pelanggan :</label>
                          <div class="col-sm-9">
                              <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama Pelanggan" minlength="2" maxlength="30" required>
                              <span id="err_nama" class="error invalid-feedback" style="display: hide;"></span>
                          </div>
                      </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
                    <button type="reset" id="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Daftar</button>
                </div>
            </form>
        </div>
      </div>
    </div>

    <form action="{{ route('logout') }}" method="POST" id="form_logout" class="d-none">
      @csrf
    </form>
    
    <!-- Main Footer -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2023 <a href="https://github.com/nafbeckh/cafe-service" target="_blank">Cafe Service</a>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
  <!-- SweetAlert2 -->
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <!-- jquery-validation -->
  <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>
  <!-- Pusher -->
  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

  @stack('js')
  <script>
    function logout_() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logout!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes!',
            confirmButtonAriaLabel: 'Thumbs up, Yes!',
            cancelButtonText: '<i class="fa fa-thumbs-down"></i> No',
            cancelButtonAriaLabel: 'Thumbs down',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                $('#form_logout').submit();
            }
        })
    }

    $('#form').submit(function(event) {
            event.preventDefault();
        }).validate({
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                $(element).addClass('is-valid');
            },
            submitHandler: function(form) {
                var formData = new FormData($(form)[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ route('pelanggan.store') }}",
                    mimeType: 'application/json',
                    dataType: 'json',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('button[type="submit"]').prop('disabled', true);
                        $('#form .error.invalid-feedback').each(function(i) {
                            $(this).hide();
                        });
                        $('#form input.is-invalid').each(function(i) {
                            $(this).removeClass('is-invalid');
                        });
                    },
                    success: function(res) {
                        $('button[type="submit"]').prop('disabled', false);
                        $('#reset').click();
                        if (res.status == true) {
                            Swal.fire(
                                'Success!',
                                res.message,
                                'success'
                            )
                        } else {
                            Swal.fire(
                                'Failed!',
                                res.message,
                                'error'
                            )
                        }
                    },
                    error: function(xhr, status, error) {
                        $('button[type="submit"]').prop('disabled', false);
                        er = xhr.responseJSON.errors
                        erlen = Object.keys(er).length
                        for (i = 0; i < erlen; i++) {
                            obname = Object.keys(er)[i];
                            $('#' + obname).addClass('is-invalid');
                            $('#err_' + obname).text(er[obname][0]);
                            $('#err_' + obname).show();
                        }
                    }
                });
            }
        });

        $(document).ready(function() {
          Pusher.logToConsole = true;

          var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
          });

          var channel = pusher.subscribe('{{ env('PUSHER_APP_CHANNEL') }}');
          channel.bind('{{ env('PUSHER_APP_CHANNEL') }}', function(data) {
            if (data.to_id == {{ auth()->user()->id }}) {
              notifSound();
              $('#counterNotif').html(data.count);
            }
          });

          countNotif();
      });

      $('#btnNotif').click(function() {
        fetchNotif();
      });

      function notifSound() {
        const audio = new Audio("{{ asset('assets/dist/audio/nofitication.wav') }}");
        audio.play();
      }

      function countNotif(){
        $.ajax({
          type: 'GET',
          url: "{{ route('notifikasi.cekNotif') }}",
          success: function(data){
            $('#counterNotif').html(data);
          },
          error: function (data) {
            console.log('Error:', data);
          }
        });
      }

      function fetchNotif(){
            $.ajax({
                type: 'GET',
                url: "{{ route('notifikasi.fetchNotif') }}",
                success: function(data){
                  let notif = '';
                  for(let i in data) {
                    notif += `<a href="" class="dropdown-item" style="${data[i].is_read ? '' : 'background:#edeff1'}">
                    <span class="d-inline-block text-truncate" style="max-width: 200px;">
                      ${data[i].title}
                    </span>
                    <span class="float-right text-sm">{{timeAgo('2023-07-19 06:00:35')}}</span>
                    </a>`;
                  }
                    $('#fetchNotif').html(notif);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
  </script>
  </body>
</html>
