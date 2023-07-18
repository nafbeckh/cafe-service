<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Menu;
use App\Models\Setting;
use App\Models\Kategori;
use App\Models\Pesanan;
use App\Models\Pesanan_detail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $cafe = Setting::first();
        if ($request->ajax()) {
            return DataTables::of(Pesanan::with('meja', 'waiter')
            ->where('status', '!=', 'Selesai')
            ->orderBy('created_at', 'asc')
            ->get())->toJson();
        }

        return view('pesanan.data', compact(['cafe']))->with('title', 'Pesanan');
    }

    public function meja()
    {
        $cafe = Setting::first();
        $meja = Meja::all();

        return view('pesanan.meja', compact(['cafe', 'meja']))->with('title', 'Pilih Meja');
    }

    public function menu(Request $request, $id)
    {
        $meja_id = $id;
        $cafe = Setting::first();
        $kategori = Kategori::all();

        return view('pesanan.menu', compact(['cafe', 'meja_id', 'kategori']))->with('title', 'Pilih Menu');
       
    }

    public function getMenu(Request $request)
    {
        if($request->ajax()){
            if($request->kategori_id == 0){
                return Menu::all()->toArray();
            } else {
                return Menu::where(['kategori_id' => $request->kategori_id])->get();
            }
        }
    }

    public function pesan(Request $request)
    {
        if($request->ajax()) {
            $pesanan = Pesanan::create([
                'no_pesanan'      => Pesanan::generateNoPesanan(),
                'meja_id'         => $request->meja_id,
                'kode_pelanggan'  => $request->kode_pelanggan ? $request->kode_pelanggan : '',
                'waiter_id'       => auth()->user()->id,
                'status'          => 'Belum dikonfirmasi',
            ]);
    
            if ($pesanan) {
                $meja = Meja::where(['id' => $pesanan->meja_id]);
                $meja->update([
                    'status'     => 'Diisi',
                    'no_pesanan' => $pesanan->no_pesanan
                ]);
    
                foreach ($request->input('menu') as $p) {
                    Pesanan_detail::create([
                        'no_pesanan'   => $pesanan->no_pesanan,
                        'menu_id'      => $p['id'],
                        'jumlah'       => $p['count'],
                    ]);
                }
    
                // $pusher = new Pusher(
                //     env('PUSHER_APP_KEY'),
                //     env('PUSHER_APP_SECRET'),
                //     env('PUSHER_APP_ID'),
                //     ['cluster' => 'ap1', 'useTLS' => true],
                // );
                
                // $nama_meja = $meja->get('no_meja');
                // $user = User::whereHas(
                //         'roles', function($q){
                //             $q->where('name', '!=', 'waiters');
                //         })->get();
                // $data = [];
                // foreach ($user as $item) {
                //     $notif = Notifikasi::create([
                //         'user_id'       => $item->id,
                //         'penjualan_id'  => $penjualan->id,
                //         'pesan'         => 'Pesanan dari ' .$nama_meja[0]->nama,
                //     ]);
    
                //     $data[] = ['count' => ($this->countNotif($item->id) - 1) + 1, 'for' => $item->id, 'is_new' => 1];
                // }
    
                // $pusher->trigger('notification', 'NotificationEvent', $data);
                
                return response()->json(['status' => true, 'message' => 'Berhasil memesan Menu']);
            } else {
                return response()->json(['status' => false, 'message' => 'Gagal memesan Menu!']);
            }
        }
    }

    public function showDetail($noPesanan)
    {
        $waiter = auth()->user()->hasRole('waiter') ? true : false;

        $cafe = Setting::first();
        $pesanan = Pesanan::with('meja')->find($noPesanan);
        $pesananDet = Pesanan_detail::with('menu')->where(['no_pesanan' => $noPesanan])->get();

        $total = Pesanan_detail::getTotal($noPesanan);

        return view('pesanan.detail', compact(['cafe', 'waiter', 'pesanan', 'pesananDet', 'total']))->with('title', 'Pesanan Meja ' . $pesanan->meja->no_meja);
    }

    public function konfirmasiPesanan(Request $request)
    {
        if($request->ajax()){
            $pesanan = Pesanan::find($request->no_pesanan);
            $pesanan->update([
                'status'    => 'Dikonfirmasi'
            ]);

            if($pesanan){
                return response()->json(['status' => true, 'message' => 'Pesanan berhasil dikonfirmasi']);
            } else{
                return response()->json(['status' => false, 'message' => 'Pesanan gagal dikonfirmasi']);
            }
        }
    }

    public function pesananSiap(Request $request)
    {
        if($request->ajax()){
            $pesanan = Pesanan::find($request->no_pesanan);
            $pesanan->update([
                'status'    => 'Pesanan Siap'
            ]);

            if($pesanan){
                return response()->json(['status' => true, 'message' => 'Pesanan siap disajikan']);
            } else{
                return response()->json(['status' => false, 'message' => 'Gagal mengubah status Pesanan']);
            }
        }
    }

    public function pesananSelesai(Request $request)
    {
        if($request->ajax()){
            $pesanan = Pesanan::find($request->no_pesanan);
            $pesanan->update([
                'status'    => 'Selesai'
            ]);

            $meja = Meja::find($pesanan->meja_id);
            $meja->update([
                'status'     => 'Kosong',
                'no_pesanan' => null
            ]);

            if($pesanan){
                return response()->json(['status' => true, 'message' => 'Pesanan berhasil diselesaikan']);
            } else{
                return response()->json(['status' => false, 'message' => 'Gagal gagal diselesaikan']);
            }
        }
    }

    public function print($no_pesanan)
    {
        $cafe = Setting::first();
        $pesanan = Pesanan::with('pesanan_detail', 'meja')->find($no_pesanan);
        if ($pesanan) {
            $total = Pesanan_detail::getTotal($no_pesanan);

            return view('pesanan.print', compact(['cafe', 'pesanan', 'total']))->with('title', 'Print Bill Pembayaran');
        } else {
            abort(404, 'belum ada pesanan');
        }
    }

}
