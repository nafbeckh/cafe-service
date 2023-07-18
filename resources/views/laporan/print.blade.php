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
            font-family: Arial, Helvetica, sans-serif;
        }

        span {
            font-size: 18px;
            font-weight: bold;
        }

        #alamat{
            margin-top: 12px;
            font-weight: bold;
        }
        
        table {
            font-size: 14px;
        }

    </style>
</head>

<body>
    <section class="laporan">
       <div class="text-center">
            <span>Laporan Pesanan {{ $cafe->nama_cafe }}<br>
            Periode {{ date('d/m/Y', strtotime($awal)) . ' s.d. ' . date('d/m/Y', strtotime($akhir)) }}</span>
            <p id="alamat">{{ $cafe->alamat }}</p>
       </div>
       <div class="text-center">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal Pesanan</th>
                        <th>Nomor Pesanan</th>
                        <th>Waiter</th>
                        <th>Total Item</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lapPesanan as $item)
                    <tr>
                        <td>{{ date('d/m/Y H:i:s', strtotime($item->tgl_pesanan)) }}</td>
                        <td>{{ $item->no_pesanan }}</td>
                        <td>{{ $item->waiter }}</td>
                        <td>{{ $item->total_item }}</td>
                        <td>{{ $item->total_harga }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
       </div>
    </section>
</body>
<script>
    window.print()
</script>
</html>