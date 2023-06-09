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
                            <th class="text-center checkbox-column dt-no-sorting"><input type="checkbox" class="text-center new-control-input chk-parent select-customers-info" data-toggle="tooltip" title="Select All Data"></th>
                            <th>Foto</th>
                            <th>Nama Menu</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th class="text-center dt-no-sorting">Aksi</th>
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

<div class="modal animated fade fadeInDown" id="modalAdd" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
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
                  <label for="nama_menu" class="col-sm-3 col-form-label">Nama Menu :</label>
                  <div class="col-sm-9">
                      <input type="text" name="nama_menu" class="form-control" id="nama_menu" placeholder="Masukkan Nama Menu" minlength="2" maxlength="35" required>
                      <span id="err_nama_menu" class="error invalid-feedback" style="display: hide;"></span>
                  </div>
                </div>
                
                <div class="form-group row">
                  <label for="kategori" class="col-sm-3 col-form-label">Kategori :</label>
                  <div class="col-sm-9">
                    <select name="kategori" id="kategori" class="form-control kategoriAdd" style="width: 100%;" required>
                      <option value="">-- Pilih --</option>
                      @foreach ($kategori as $item)
                      <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                      @endforeach
                    </select>
                    <span id="err_kategori" class="error invalid-feedback" style="display: hide;"></span>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="harga" class="col-sm-3 col-form-label">Harga :</label>
                  <div class="col-sm-9">
                      <input type="text" name="harga" class="form-control" id="harga" placeholder="Masukkan Harga" minlength="2" required>
                      <span id="err_harga" class="error invalid-feedback" style="display: hide;"></span>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="foto" class="col-sm-3 col-form-label">Foto :</label>
                  <div class="col-sm-9">
                      <div class="custom-file">
                        <input type="file" name="foto" class="custom-file-input @error('foto') is-invalid @enderror" id="foto">
                        <label class="custom-file-label" for="foto">Pilih Foto</label>
                      </div>
                      <span id="err_foto" class="error invalid-feedback" style="display: hide;"></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
                <button type="reset" id="reset" class="btn btn-secondary">Reset</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
  </div>
</div>

<div class="modal animated fade fadeInDown" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="titleEdit">Edit Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="tooltip" title="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="formEdit" action="" method="POST" enctype="multipart/form-data">
            {{ method_field('PUT') }}
            <div class="modal-body">
                <div class="container">
                    <div class="form-group row">
                        <label for="edit_nama_menu" class="col-sm-3 col-form-label">Nama Menu :</label>
                        <div class="col-sm-9">
                            <input type="text" name="nama_menu" class="form-control" id="edit_nama_menu" placeholder="Masukkan Nama Menu" minlength="2" maxlength="35" required>
                            <span id="err_edit_nama_menu" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="edit_kategori" class="col-sm-3 col-form-label">Kategori :</label>
                        <div class="col-sm-9">
                          <select name="kategori" id="edit_kategori" class="form-control kategoriEdit" style="width: 100%;">
                            <option value="">-- Pilih --</option>
                            @foreach ($kategori as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                            @endforeach
                          </select>
                          <span id="err_edit_kategori" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                      </div>
      
                      <div class="form-group row">
                        <label for="edit_harga" class="col-sm-3 col-form-label">Harga :</label>
                        <div class="col-sm-9">
                            <input type="text" name="harga" class="form-control" id="edit_harga" placeholder="Masukkan Nama Menu" minlength="2" maxlength="35" required>
                            <span id="err_edit_harga" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="edit_foto" class="col-sm-3 col-form-label">Foto :</label>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <input type="file" name="foto" class="custom-file-input" id="edit_foto">
                                <label class="custom-file-label" for="foto">Pilih Foto</label>
                            </div>
                            <span id="err_edit_foto" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
                <button type="button" id="edit_reset" class="btn btn-secondary">Reset</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
  </div>
</div>


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

        $('.kategoriAdd').select2({
          theme: 'bootstrap4',
          dropdownParent: $("#modalAdd"),
        })

        $('.kategoriEdit').select2({
          theme: 'bootstrap4',
          dropdownParent: $("#modalEdit"),
        })

        var table = $('#tableData').DataTable({
            processing: true,
            serverSide: true,
            rowId: 'id',
            ajax: "{{ route('menu.index') }}",
            lengthChange: false,
            'stateSave': false,
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
            "dom": "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "buttons": {
                text: 'Tambah',
                action: function(e, dt, node, config) {
                    $('#modalAdd').modal('show');
                }
            },
            autoWidth: false,
            order: [[ 1, "asc" ]],
            columnDefs: [
                {
                    targets: 0,
                    width: "30px",
                    className: "text-center",
                    orderable: !1,
                },
                {
                    targets: 5,
                    className: "text-center",
                }
            ],
            'select': {
                'style': 'multi'
            },
            columns: [{
                    data: 'id',
                    render: function(data, type, row, meta) {
                        return `<input type="checkbox" name="id[]" value="${data}" class="new-control-input child-chk select-customers-info">`
                    }
                },
                {
                    data: 'foto',
                    title: 'Foto',
                    render: function(data, type, row, meta) {
                        let text = `<img src="assets/dist/img/menu/${data}" width="60" height="60">`;
                        return text;
                    }
                },
                {
                    data: 'nama_menu',
                    title: 'Nama Menu'
                },
                {
                    data: 'kategori.nama_kategori',
                    title: 'Kategori'
                },
                {
                    data: 'harga',
                    title: 'Harga'
                },
                {
                    title: 'Aksi',
                    "data": 'id',
                    render: function(data, type, row, meta) {
                        let text = `<div class="btn-group">
                        <button type="button" id="btnEdit" data-id="${data}" class="btn btn-xs bg-gradient-warning"><i class="fas fa-pencil-alt text-white" data-toggle="tooltip" data-placement="top" title="Edit"></i></button>
                        <button type="button" id="btnDelete" data-id="${data}" class="btn btn-xs bg-gradient-danger"><i class="fas fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Delete"></i></button>
                        </div>`;
                        return text;
                    }
                }
            ],
            "buttons": [{
                text: '<i class="fa fa-plus mr-2"></i>Baru',
                className: 'btn btn-sm btn-primary bs-tooltip',
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Tambah data baru'
                },
                action: function(e, dt, node, config) {
                    $('#modalAdd').modal('show');
                    $('#nama_menu').focus();
                }
            }, {
                text: '<i class="fas fa-trash mr-2"></i>Hapus',
                className: 'btn btn-sm btn-danger',
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Hapus yang dipilih'
                },
                action: function(e, dt, node, config) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes!',
                        confirmButtonAriaLabel: 'Thumbs up, Yes!',
                        cancelButtonText: '<i class="fa fa-thumbs-down"></i> No',
                        cancelButtonAriaLabel: 'Thumbs down',
                        padding: '2em'
                    }).then(function(result) {
                        if (result.value) {
                            $("#formDeleteBatch").submit();
                        }
                    })
                }
            }, {
                className: 'btn btn-sm btn-primary',
                extend: "pageLength",
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Page Length'
                }
            }],
            "stripeClasses": [],
            initComplete: function() {
                $('#tableData').DataTable().buttons().container().appendTo('#tableData_wrapper .col-md-6:eq(0)');
            }
        });

        multiCheck(table);

        var id;

        $('body').on('click', '#btnDelete', function() {
            id = $(this).data("id");
            let url = "{{ route('menu.destroy', ':id') }}";
            url = url.replace(':id', id);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
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
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }
                    });
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        success: function(res) {
                            table.ajax.reload();
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
                        error: function(data) {
                            console.log('Error:', data);
                            Swal.fire(
                                'Failed!',
                                'Server Error',
                                'error'
                            )
                        }
                    });
                }
            })
        });

        $('#edit_reset').click(function() {
            id = $(this).val();
            $('#formEdit .error.invalid-feedback').each(function(i) {
                $(this).hide();
            });
            $('#formEdit input.is-invalid').each(function(i) {
                $(this).removeClass('is-invalid');
            });
            let url = "{{ route('menu.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                method: 'GET',
                success: function(result) {
                    $('#edit_reset').val(result.data.id);
                    $('#edit_nama_menu').val(result.data.nama_menu);
                    $('#edit_harga').val(result.data.harga);
                    var option = new Option(result.data.kategori.nama_kategori, result.data.kategori_id, true, true);
                    $('#edit_kategori').append(option).trigger('change');
                },
                error: function(xhr, status, error) {
                    er = xhr.responseJSON.errors
                    Swal.fire(
                        'Failed!',
                        'Server Error',
                        'error'
                    )
                }
            });
            $('#modalEdit').modal('show');
        })

        $('body').on('click', '#btnEdit', function() {
            $('#formEdit .error.invalid-feedback').each(function(i) {
                $(this).hide();
            });
            $('#formEdit input.is-invalid').each(function(i) {
                $(this).removeClass('is-invalid');
            });
            id = $(this).data('id');
            let url = "{{ route('menu.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                method: 'GET',
                success: function(result) {
                    $('#edit_reset').val(result.data.id);
                    $('#edit_nama_menu').val(result.data.nama_menu);
                    $('#edit_harga').val(result.data.harga);
                    var option = new Option(result.data.kategori.nama_kategori, result.data.kategori_id, true, true);
                    $('#edit_kategori').append(option).trigger('change');
                },
                error: function(xhr, status, error) {
                    er = xhr.responseJSON.errors
                    Swal.fire(
                        'Failed!',
                        'Server Error',
                        'error'
                    )
                }
            });
            $('#modalEdit').modal('show');

        })

        $('#formEdit').submit(function(event) {
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
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                var formData1 = new FormData($(form)[0]);
                let url = "{{ route('menu.update', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: 'POST',
                    url: url,
                    mimeType: 'application/json',
                    dataType: 'json',
                    data: formData1,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('button[type="submit"]').prop('disabled', true);
                        $('#formEdit .error.invalid-feedback').each(function(i) {
                            $(this).hide();
                        });
                        $('#formEdit input.is-invalid').each(function(i) {
                            $(this).removeClass('is-invalid');
                        });
                    },
                    success: function(res) {
                        table.ajax.reload();
                        $('button[type="submit"]').prop('disabled', false);
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
                        console.log(xhr)
                        erlen = Object.keys(er).length
                        for (i = 0; i < erlen; i++) {
                            obname = Object.keys(er)[i];
                            $('#' + obname).addClass('is-invalid');
                            $('#err_edit_' + obname).text(er[obname][0]);
                            $('#err_edit_' + obname).show();
                        }
                    }
                });
            }
        });;

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
                    url: "{{ route('menu.store') }}",
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
                        table.ajax.reload();
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

        $('#formDeleteBatch').submit(function(event) {
            var form = this;

            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{ route('menu.destroy.batch') }}",
                data: $(form).serialize(),
                beforeSend: function() {
                    console.log('otw')
                },
                success: function(res) {
                    table.ajax.reload();
                    if (res.status == true) {
                        Swal.fire(
                            'Deleted!',
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

                    table.rows('.selected').nodes().to$().removeClass('selected');
                    er = xhr.responseJSON.errors
                    console.log(er);
                    Swal.fire(
                        'Failed!',
                        'Server Error',
                        'error'
                    )
                }
            })

        });

    });
</script>
@endpush
