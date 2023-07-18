<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $cafe->nama_cafe }} | {{ $title }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <style>
        *,
        ::after,
        ::before {
            box-sizing: unset;
            font-size:12px;
        }

    </style>
</head>

<body>
    <div class="wrapper" style="width: 60mm;height: 110%;font-family:'PT Sans', sans-serif;color: black;">
        <!-- Main content -->
        <section class="invoice">
            <div class="text-center">
                <img src="{{ asset('assets/dist/img') }}/{{ $cafe->path_logo }}" alt="Logo" class="brand-image" style="width: 30%;">
                <br><b><span style="font-size: 16px">{{ $cafe->nama_cafe }}</span></b>
                <br><span>{{ $cafe->alamat }}</span>
                <br><span>{{ $cafe->telp }}</span>
            </div>
            <div class="text-left">
                <br>No. Meja: {{ $pesanan->meja->no_meja }}
                @if($pesanan->kode_pelanggan != '')
                <br>Pelanggan: {{ $pesanan->pelanggan->nama }}
                @endif
                <br>No. Pesanan: {{ $pesanan->no_pesanan }}
                <br>Tgl Pesanan: {{ date('d/m/Y H:i:s', strtotime($pesanan->created_at)) }}
                <br>
            </div>
            <div class="row">
                <div class="col-11">
                    ================================
                    <table style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="text-align: left;">Menu</th>
                                <th style="text-align: right;">Hrg</th>
                                <th style="text-align: right;">Qty</th>
                                <th style="text-align: right;">Sub</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanan->pesanan_detail as $item)
                            <tr>
                                <td style="text-align: left;">{{ $item->menu->nama_menu }}</td>
                                <td style="text-align: right;">{{ format_uang($item->menu->harga) }}</td>
                                <td style="text-align: right;">{{ $item->jumlah }}</td>
                                <td style="text-align: right;">{{ format_uang($item->jumlah * $item->menu->harga) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-11">
                    ================================
                    <table style="width: 100%">
                        <tr>
                            <th style="text-align: right;">Total Harga :</th>
                            <th style="text-align: right;">{{ format_uang($total) }}</th>
                        </tr>
                    </table>
                    ================================
                    <div class="text-center">
                        Cetak : {{ date('d/m/Y H:i:s') }}
                        <br>Waiter : {{ auth()->user()->nama }}
                    </div>
                </div>
            </div>
        </section>
    </div>

</body>
<script>
    window.print()
</script>

</html>