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
      <!-- Font Awesome -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
      <!-- Theme style -->
      <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
      <!-- overlayScrollbars -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
      <!-- SweetAlert2 -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
      @stack('css')
    </head>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown" id="btnNotif">
              <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge" data-count="" id="counterNotif"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="fetchNotf">
                <div id="fetchNotif">
                  
                </div>
                <a href="{{ asset('notifikasi') }}" class="dropdown-item dropdown-footer">Lihat Semua Notifikasi</a>
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
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('dashboard') }}" class="brand-link">
          <img src="{{ asset('assets/dist/img') }}/{{ $cafe->path_logo }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">{{ $cafe->nama_cafe }}</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="{{ asset('assets/dist/img') }}/{{ auth()->user()->foto }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="javascript:void(0);" class="d-block">{{ auth()->user()->nama }} <span class="badge @hasrole('admin') badge-success @else badge-danger @endhasrole">
                @if(auth()->user()->hasRole('admin'))
                  admin
                @elseif(auth()->user()->hasRole('chef'))
                  chef
                @else
                  waiter
                @endif
              </span></a>
            </div>
          </div>

          <!-- Sidebar Menu -->
          @include('layouts.sidebar')
          <!-- /.sidebar-menu -->

        </div>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        @yield('content')
      </div>

      <!-- /.content-wrapper -->
      <footer class="main-footer">
        <strong>Copyright &copy; 2023 <a href="https://github.com/nafbeckh/cafe-service" target="_blank">Cafe Service</a>
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    
    <form action="{{ route('logout') }}" method="POST" id="form_logout" class="d-none">
      @csrf
    </form>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
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

      $(document).ready(function() {
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
          cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
        });

        var channel = pusher.subscribe('{{ env('PUSHER_APP_CHANNEL') }}');
        channel.bind('{{ env('PUSHER_APP_CHANNEL') }}', function(data) {
          for (let i = 0; i < data.length; i++){
            if (data[i].to_id == {{ auth()->user()->id }}) {
              notifSound();
              $('#counterNotif').html(data[i].count);
            }
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
