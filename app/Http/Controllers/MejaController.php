<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Setting;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MejaController extends Controller
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
            return DataTables::of(Meja::query())->toJson();
        }

        return view('meja.data', compact(['cafe']))->with('title', 'Meja');
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
            'no_meja'    => 'required|max:50|min:2|unique:mejas,no_meja',
        ]);
        $meja = Meja::latest()->first() ?? new Meja();
        $meja = Meja::create([
            'no_meja'            => $request->no_meja,
        ]);
        if ($meja) {
            return response()->json(['status' => true, 'message' => 'Berhasil menambahkan data Meja']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal menambahkan data Meja']);
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
        if ($request->ajax()) {
            $meja = Meja::find($meja->id);
            return response()->json(['status' => true, 'message' => '', 'data' => $meja]);
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
    public function update(Request $request, Meja $meja)
    {
        $this->validate($request, [
            'no_meja'      => 'required|max:50|min:2|unique:mejas,no_meja,' . $meja->id,
        ]);
        $meja = Meja::findOrFail($meja->id);
        $meja->update([
            'no_meja'            => $request->no_meja,
        ]);

        if ($meja) {
            return response()->json(['status' => true, 'message' => 'Berhasil mengubah data Meja']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal Imengubah data Meja']);
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
        $meja = Meja::findOrFail($id);
        $meja->delete();

        if ($meja) {
            return response()->json(['status' => true, 'message' => 'Berhasil menhapus data Meja']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal menhapus data Meja']);
        }
    }

    public function destroyBatch(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $id) {
                $meja = Meja::findOrFail($id);
                $meja->delete();
            }

            return response()->json(['status' => true, 'message' => 'Berhasil menhapus data Meja']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal menhapus data Meja']);
        }
    }
}
