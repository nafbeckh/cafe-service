<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Setting;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cafe = Setting::first();
        $kategori = Kategori::all();
        if ($request->ajax()) {
            return DataTables::of(Menu::with('kategori')->get())->toJson();
        }

        return view('menu.data', compact(['cafe', 'kategori']))->with('title', 'Menu');
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
            'nama_menu'      => 'required|max:35|min:2',
            'kategori'       => 'required',
            'harga'          => 'required',
            'foto'           => 'required|mimes:jpg,jpeg,png|max:10240'
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/assets/dist/img/menu'), $nama);
            $foto = $nama;
        }

        $menu = Menu::create([
            'nama_menu'     => $request->nama_menu,
            'kategori_id'   => $request->kategori,
            'harga'         => $request->harga,
            'foto'          => $foto
        ]);

        if ($menu) {
            return response()->json(['status' => true, 'message' => 'Berhasil menambahkan data Menu']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal menambahkan data Menu']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Menu $menu)
    {
        if ($request->ajax()) {
            $menu = Menu::with('kategori')->find($menu->id);
            return response()->json(['status' => true, 'message' => '', 'data' => $menu]);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        if ($request->hasFile('foto')) {
            $this->validate($request, [
                'nama_menu'      => 'required|max:35|min:2',
                'kategori'       => 'required',
                'harga'          => 'required',
                'foto'           => 'required|mimes:jpg,jpeg,png|max:10240'
            ]);
        } else {
            $this->validate($request, [
                'nama_menu'      => 'required|max:35|min:2',
                'kategori'       => 'required',
                'harga'          => 'required'
            ]);
        }

        $menu = Menu::findOrFail($menu->id);
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $foto = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            File::delete(public_path('/assets/dist/img/menu/') . $menu->foto);
            $file->move(public_path('/assets/dist/img/menu'), $foto);
            $menu->update([
                'nama_menu'     => $request->nama_menu,
                'kategori_id'   => $request->kategori,
                'harga'         => $request->harga,
                'foto'          => $foto
            ]);
        } else {
            $menu->update([
                'nama_menu'     => $request->nama_menu,
                'kategori_id'   => $request->kategori,
                'harga'         => $request->harga
            ]);
        }

        if ($menu) {
            return response()->json(['status' => true, 'message' => 'Berhasil mengubah data Menu']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal mengubah data Menu']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        File::delete(public_path('/assets/dist/img/menu/') . $menu->foto);
        $menu->delete();

        if ($menu) {
            return response()->json(['status' => true, 'message' => 'Berhasil menghapus data Menu']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data Menu']);
        }
    }

    public function destroyBatch(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $id) {
                $menu = Menu::findOrFail($id);
                File::delete(public_path('/assets/dist/img/menu/') . $menu->foto);
                $menu->delete();
            }

            return response()->json(['status' => true, 'message' => 'Berhasil menghapus data Menu']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data Menu']);
        }
    }
}
