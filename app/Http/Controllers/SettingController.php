<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

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
                'nama_cafe'     => 'required|max:25|min:3',
                'alamat'        => 'required',
                'diskon'        => 'required',
                'per_pesanan'   => 'required',
                'foto'          => 'required|mimes:jpg,jpeg,png|max:10240',
            ]);
        } else {
            $this->validate($request, [
                'nama_cafe'     => 'required|max:25|min:3',
                'diskon'        => 'required',
                'per_pesanan'   => 'required',
                'alamat'        => 'required',
            ]);
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama = 'logo-' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            File::delete(public_path('/assets/dist/img/') . $setting->path_logo);
            $file->move(public_path('/assets/dist/img'), $nama);
            $setting->update([
                'nama_cafe'     => $request->nama_cafe,
                'alamat'        => $request->alamat,
                'diskon'        => $request->diskon,
                'per_pesanan'   => $request->per_pesanan,
                'path_logo'     => $nama,
                'path_logo'     => $nama,
            ]);
        } else {
            $setting->update([
                'nama_cafe'     => $request->nama_cafe,
                'diskon'        => $request->diskon,
                'per_pesanan'   => $request->per_pesanan,
                'alamat'        => $request->alamat,
            ]);
        }
        
        if ($setting) {
            return back()->with(['success' => 'Setting berhasil diubah']);
        } else {
            return back()>with(['error' => 'Setting gagal diubah!']);
        }
    }

    public function profile()
    {
        $cafe = Setting::first();
        return view('setting.profile', compact(['cafe']))->with('title', 'Setting Profile');
    }

    public function profileUpdate(Request $request)
    {
        $user = User::find(Auth::id());
        if ($request->password == '' && $request->foto == '') {
            $this->validate($request, [
                'nama'      => 'required|max:25|min:3',
            ]);
        } elseif ($request->password == '' && $request->foto != '') {
            $this->validate($request, [
                'nama'      => 'required|max:25|min:3',
                'foto'      => 'required|mimes:jpg,jpeg,png|max:10240',
            ]);
        } elseif ($request->password != '' && $request->foto == '') {
            $this->validate($request, [
                'nama'      => 'required|max:25|min:3',
                'password'  => ['required', 'same:confirmPassword', Password::min(5)->numbers()],
                'confirmPassword' => 'required',
            ]);
        } else {
            $this->validate($request, [
                'nama'      => 'required|max:25|min:3',
                'foto'      => 'required|mimes:jpg,jpeg,png|max:10240',
                'password'  => ['required', 'same:confirmPassword', Password::min(5)->numbers()],
                'confirmPassword' => 'required',
            ]);
        }

        if ($request->password == '' && $request->foto == '') {
            $user->update([
                'nama'        => $request->nama,
            ]);
        } elseif ($request->password == '' && $request->foto != '') {
            File::delete(public_path('/assets/dist/img/') . $user->foto);
            $file = $request->file('foto');
            $nama = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/assets/dist/img'), $nama);
            $foto = $nama;
            $user->update([
                'nama'        => $request->nama,
                'foto'        => $foto,
            ]);
        } elseif ($request->password != '' && $request->foto == '') {
            $user->update([
                'nama'        => $request->nama,
                'password'    => Hash::make($request->password),
            ]);
        } else {
            File::delete(public_path('/assets/dist/img/') . $user->foto);
            $file = $request->file('foto');
            $nama = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/assets/dist/img'), $nama);
            $foto = $nama;
            $user->update([
                'nama'        => $request->nama,
                'foto'        => $foto,
                'password'    => Hash::make($request->password),
            ]);
        }
        if ($user) {
            return back()->with(['success' => 'Profile berhasil diubah']);
        } else {
            return back()->with(['success' => 'Profile gagal diubah!']);
        }
    }
}
