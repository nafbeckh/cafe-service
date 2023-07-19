<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Pesanan;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NotifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cafe = Setting::first();
        if ($request->ajax()) {
            return DataTables::of(Notifikasi::with('from')
            ->where(['to_id' => auth()->user()->id])
            ->get())->toJson();
        }

        return view('notifikasi.data', compact(['cafe']))->with('title', 'Notifikasi');
    }

    public function show($id)
    {
        $waiter = auth()->user()->hasRole('waiter') ? true : false;

        $cafe = Setting::first();
        $notifikasi = Notifikasi::with('from')->findOrFail($id);

        return view('notifikasi.detail', compact(['cafe', 'waiter', 'notifikasi']))->with('title', 'Detail Notifikasi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);

        $pesanan = Pesanan::where(['no_pesanan' => $notifikasi->no_pesanan])->first();

        if($pesanan->status == 'Selesai'){
            $notifikasi->delete();

            if ($notifikasi) {
                return response()->json(['status' => true, 'message' => 'Berhasil menghapus notifikasi']);
            } else {
                return response()->json(['status' => false, 'message' => 'Gagal menghapus notifikasi']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Tidak bisa menghapus notifikasi jika pesanan belum selesai']);
        }
    }

    public function cekNotif(Request $request)
    {
        if ($request->ajax()) {
            $notif = Notifikasi::where(['to_id' => auth()->user()->id, 'is_read' => '0'])->count();
            return $notif ? $notif : '';
        }
    }

    public function fetchNotif(Request $request)
    {
        if ($request->ajax()) {
            return Notifikasi::where(['to_id' => auth()->user()->id])->orderByDesc('created_at')->limit(3)->get();
        }
    }

}
