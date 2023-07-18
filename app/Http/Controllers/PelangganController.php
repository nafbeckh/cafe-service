<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'kode_pelanggan'  => 'required|max:12|min:6|unique:pelanggans,kode_pelanggan',
            'nama'            => 'required|max:30|min:2',
        ]);
        $pelanggan = Pelanggan::latest()->first() ?? new Pelanggan();
        $pelanggan = Pelanggan::create([
            'kode_pelanggan'  => $request->kode_pelanggan,
            'nama'            => $request->nama
        ]);
        if ($pelanggan) {
            return response()->json(['status' => true, 'message' => 'Pelanggan berhasil terdaftar']);
        } else {
            return response()->json(['status' => false, 'message' => 'Pelanggan gagal terdaftar']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Meja  $meja
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Meja $meja)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meja $meja)
    {
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    
    }

}
