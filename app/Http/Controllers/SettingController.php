<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cafe = Setting::first();
        return view('setting.cafe', compact(['cafe']))->with('title', 'Setting Cafe');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $setting = Setting::first();
        if ($request->hasFile('foto')) {
            $this->validate($request, [
                'nama_cafe' => 'required|max:25|min:3',
                'alamat'    => 'required',
                'foto'      => 'required|mimes:jpg,jpeg,png|max:10240',
            ]);
        } else {
            $this->validate($request, [
                'nama_cafe' => 'required|max:25|min:3',
                'alamat'    => 'required',
            ]);
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama = 'logo-' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            File::delete(public_path('/assets/dist/img/') . $setting->path_logo);
            $file->move(public_path('/assets/dist/img'), $nama);
            $setting->update([
                'nama_cafe' => $request->nama_cafe,
                'alamat' => $request->alamat,
                'path_logo' => $nama,
            ]);
        } else {
            $setting->update([
                'nama_cafe' => $request->nama_cafe,
                'alamat' => $request->alamat,
            ]);
        }
        
        if ($setting) {
            return back()->with(['success' => 'Setting berhasil diubah']);
        } else {
            return back()>with(['error' => 'Setting gagal diubah!']);
        }
    }
}
