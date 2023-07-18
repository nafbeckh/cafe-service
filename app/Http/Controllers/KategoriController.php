<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Setting;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
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
            return DataTables::of(Kategori::query())->toJson();
        }
        
        return view('kategori.data', compact(['cafe']))->with('title', 'Kategori Menu');
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
            'nama_kategori'      => 'required|max:25|min:2',
        ]);

        $kategori = Kategori::create([
            'nama_kategori'     => $request->nama_kategori,
        ]);
        if ($kategori) {
            return response()->json(['status' => true, 'message' => 'Berhasil menambahkan data Kategori Menu']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal menambahkan data Kategori Menu']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Kategori $kategori)
    {
        if ($request->ajax()) {
            $kategori = Kategori::find($kategori->id);
            return response()->json(['status' => true, 'message' => '', 'data' => $kategori]);
        } else {
            abort(404);
        }
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kategori $kategori)
    {
        $this->validate($request, [
            'nama_kategori'      => 'required|max:25|min:2|unique:kategoris,nama_kategori,' . $kategori->id,
        ]);

        $kategori = Kategori::findOrFail($kategori->id);
        $kategori->update([
            'nama_kategori'        => $request->nama_kategori,
        ]);

        if ($kategori) {
            return response()->json(['status' => true, 'message' => 'Berhasil mengubah data Kategori Menu']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal Imengubah data Kategori Menu']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        if ($kategori) {
            return response()->json(['status' => true, 'message' => 'Berhasil menghapus data Kategori Menu']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data Kategori Menu']);
        }
    }

    public function destroyBatch(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $id) {
                $kategori = Kategori::findOrFail($id);
                $kategori->delete();
            }

            return response()->json(['status' => true, 'message' => 'Berhasil menghapus data Kategori Menu']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data Kategori Menu']);
        }
    }
}
