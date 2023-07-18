<?php

namespace App\Http\Controllers;

use App\Models\Lap_pesanan;
use App\Models\Setting;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $awal = $request->awal;
            $akhir = $request->akhir;

            $data = DataTables::of(Lap_pesanan::
                    whereBetween('tgl_pesanan', [$awal . ' 00:00:00', $akhir . ' 23:59:59'])
                    ->orderBy('tgl_pesanan', 'asc')->get())->toJson();

            return $data;
        }
      
        $cafe = Setting::first();
        return view('laporan.pesanan', compact(['cafe']))->with('title', 'Laporan Pesanan');
    }

    public function print()
    {
        $awal = $_GET['awal'];
        $akhir = $_GET['akhir'];
        
        $cafe = Setting::first();
        $lapPesanan = Lap_pesanan::
        whereBetween('tgl_pesanan', [$awal . ' 00:00:00', $akhir . ' 23:59:59'])
        ->orderBy('tgl_pesanan', 'asc')->get();

        if ($lapPesanan) {
            return view('laporan.print', compact(['cafe', 'lapPesanan', 'awal', 'akhir']))->with('title', 'Print Laporan Pesanan');
        } else {
            abort(404);
        }
    }
}
