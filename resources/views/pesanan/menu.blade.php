@extends('layouts.user-template')

@push('css')
<style>
  .img-replace {
    height: 180px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }
</style>
@endpush

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
          <li class="breadcrumb-item"><a href="{{ route('pesanan.meja') }}">Home</a></li>
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
      <div class="col-5 col-sm-3">
        <div class="card">
          <div class="cad-body">
            <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link active" id="vert-tabs-semua-tab" data-toggle="pill" onclick="getKategori(0)" role="tab" aria-controls="vert-tabs-semua" aria-selected="true">Semua</a>
              @foreach($kategori as $item)
              <a class="nav-link" id="vert-tabs-{{ $item->nama_kategori }}-tab" data-toggle="pill" onclick="getKategori({{ $item->id }})" role="tab" aria-controls="vert-tabs-{{ $item->nama_kategori }}" aria-selected="false">{{ $item->nama_kategori }}</a>
              @endforeach
            </div>
          </div>

        </div>
      </div>
      <div class="col-7 col-sm-9">
        <div class="row" id="load-item">

        </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<div class="modal animated fade fadeInDown" id="modalCart" role="dialog" aria-labelledby="modalCart" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Keranjang Pesanan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" data-toggle="tooltip" title="Close">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div class="form-group row">
              <label for="kode_pelanggan" class="col-sm-3 col-form-label">Kode Pelanggan :</label>
              <div class="col-sm-5">
                  <input type="text" name="kode_pelanggan" class="form-control" id="kode_pelanggan" placeholder="Masukkan Kode Pelanggan" minlength="6" maxlength="12" required>
                  <span id="err_kode_pelanggan" class="error invalid-feedback" style="display: hide;"></span>
              </div>
            </div>

            <div class="container show-cart">
            </div>
          </div>
          <div class="modal-footer">
              <h5 class="mr-auto" id="total-cart"></h5>
              <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-default clear-cart">Reset</button>
              <button type="submit" class="btn btn-success" id="pesanMenu">Pesan</button>
          </div>
      </div>
  </div>
</div>
@endsection

@push('js')
<script>
  $(document).ready(function() {
    getKategori(0);
  });

  function hrg(x) {
    let a = parseInt(x)
    return a.toLocaleString('id-ID')
  }

  function getKategori(id) {
    $.ajax({
      method: 'GET',
      url: "{{ route('pesanan.getmenu') }}",
      data: {kategori_id: id},
      success: function(result) {
        let item = '';
        for(var i in result) {
          item += `<div class="col-md-12 col-lg-3">
            <div class="card">
              <div class="img-replace" style="background-image: url({{ asset('assets/dist/img/menu') }}/${result[i].foto})"></div>
              <div class="card-body">
                  <h5 class="text-center mb-0">${result[i].nama_menu}</h5>
                  <p class="text-muted text-center mb-2">Rp${hrg(result[i].harga)}</p>

                  <button class="btn btn-outline-success btn-block btn-sm" data-id="${result[i].id}" data-name="${result[i].nama_menu}" data-price="${result[i].harga}" onclick="addToCart(this)">Tambahkan</button>
              </div>
            </div>
          </div>`;
        }
        
        $('#load-item').html(item);
      },
      error: function(error) {
        console.log(error);
      }
    });
  }

  $('#pesanMenu').click(function() {
    let cartArray = shoppingCart.listCart();

    let kode_pelanggan = $('#kode_pelanggan').val();
    Swal.fire({
      title: 'Are you sure?',
      text: "Pesan Menu?",
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
          url: "{{ route('pesanan.pesan') }}",
          data: {
            meja_id: "{{ $meja_id }}",
            kode_pelanggan: kode_pelanggan,
            menu: cartArray,
          },
          success: function (res) {
            shoppingCart.clearCart();
            Swal.fire(
              'Success!',
              res.message,
              'success'
            ).then(function () {
              location.href = "{{ route('pesanan.meja') }}";
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
  })
</script>

<!-- Add To Cart -->
<script>
  var shoppingCart = (function() {
  cart = [];
  
  // Constructor
  function Item(id, name, price, count) {
      this.id = id;
      this.name = name;
      this.price = price;
      this.count = count;
  }
  
  // Save cart
  function saveCart() {
      sessionStorage.setItem('shoppingCart', JSON.stringify(cart));
  }
  
      // Load cart
  function loadCart() {
      cart = JSON.parse(sessionStorage.getItem('shoppingCart'));
  }
  if (sessionStorage.getItem("shoppingCart") != null) {
      loadCart();
  }
  

  var obj = {};
  
  // Add to cart
  obj.addItemToCart = function(id, name, price, count) {
      for(var item in cart) {
        if(cart[item].id === id) {
            cart[item].count ++;
            saveCart();
            return;
        }
      }
      var item = new Item(id, name, price, count);
      cart.push(item);
      saveCart();
  }
  // Set count from item
  obj.setCountForItem = function(id, count) {
      for(var i in cart) {
        if (cart[i].id === id) {
            cart[i].count = count;
            break;
        }
      }
  };

  // Remove item from cart
  obj.removeItemFromCart = function(id) {
      for(var item in cart) {
          if(cart[item].id === id) {
          cart[item].count --;
          if(cart[item].count === 0) {
              cart.splice(item, 1);
          }
          break;
          }
      }
      saveCart();
  }

  // Remove all items from cart
  obj.removeItemFromCartAll = function(id) {
      for(var item in cart) {
      if(cart[item].id === id) {
          cart.splice(item, 1);
          break;
      }
      }
      saveCart();
  }

  // Clear cart
  obj.clearCart = function() {
      cart = [];
      saveCart();
  }

  // Count cart 
  obj.totalCount = function() {
      var totalCount = 0;
      for(var item in cart) {
      totalCount += cart[item].count;
      }
      return totalCount ? totalCount : '';
  }

  // Total cart
  obj.totalCart = function() {
      var totalCart = 0;
      for(var item in cart) {
      totalCart += cart[item].price * cart[item].count;
      }
      return Number(totalCart.toFixed(2));
  }

  // List cart
  obj.listCart = function() {
      var cartCopy = [];
      for(i in cart) {
      item = cart[i];
      itemCopy = {};
      for(p in item) {
          itemCopy[p] = item[p];

      }
      itemCopy.total = Number(item.price * item.count).toFixed(2);
      cartCopy.push(itemCopy)
      }
      return cartCopy;
  }

  return obj;
  })();

  function addToCart(e) {
      var id = $(e).data('id');
      var name = $(e).data('name');
      var price = Number($(e).data('price'));
      shoppingCart.addItemToCart(id, name, price, 1);
      displayCart();
  }

  // Clear items
  $('.clear-cart').click(function() {
      shoppingCart.clearCart();
      displayCart();
  });

  function displayCart() {
      var cartArray = shoppingCart.listCart();
      var output = "";
      for(var i in cartArray) {
          output += '<div class="card">'
              + '<div class="card-body">'
              + '<div class="row">'
              + '<div class="col-sm-6">'
              + '<h5 class="card-title"><b>' + cartArray[i].name + '</b></h5>'
              + '<p class="card-text">Rp '+ hrg(cartArray[i].price) +'</p></div>'
              + '<div class="col-sm text-right">'
              + '<div class="btn-group" role="group">'
              + '<button type="button" class="btn btn-default mr-2 minus-item" data-id="'+ cartArray[i].id +'"><i class="fas fa-minus"></i></button>'
              + '<input type="text" class="form-control text-center mr-2 item-count" style="width: 40px" name="jumlah" data-id="'+ cartArray[i].id +'" value="'+ cartArray[i].count +'">'
              + '<button type="button" class="btn btn-default mr-2 plus-item" data-id="'+ cartArray[i].id +'"><i class="fas fa-plus"></i></button>'
              + '<button type="button" class="btn btn-danger delete-item" data-id="'+ cartArray[i].id +'">Hapus</button>'
              + '</div></div></div></div></div>';
      }
      $('.show-cart').html(output);
      $('#total-cart').html('Total: Rp ' + hrg(shoppingCart.totalCart()));
      $('.total-count').html(shoppingCart.totalCount());
  }

  // Delete item button
  $('.show-cart').on("click", ".delete-item", function(event) {
      var id = $(this).data('id')
      shoppingCart.removeItemFromCartAll(id);
      displayCart();
  })

  // -1
  $('.show-cart').on("click", ".minus-item", function(event) {
      var id = $(this).data('id')
      shoppingCart.removeItemFromCart(id);
      displayCart();
  })
  
  // +1
  $('.show-cart').on("click", ".plus-item", function(event) {
      var id = $(this).data('id')
      shoppingCart.addItemToCart(id);
      displayCart();
  })

  // Item count input
  $('.show-cart').on("change", ".item-count", function(event) {
      var id = $(this).data('id');
      var count = Number($(this).val());
      shoppingCart.setCountForItem(id, count);
      displayCart();
  });

  displayCart();

</script>
@endpush
