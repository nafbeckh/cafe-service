<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
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
            return DataTables::of(User::with('roles')->get())->toJson();
        }

        return view('user.data', compact(['cafe']))->with('title', 'User');
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
            'nama'      => 'required|max:25|min:3',
            'username'  => 'required|unique:users,username',
            'password'  => 'required|min:5',
            'foto'      => 'required|mimes:jpg,jpeg,png|max:10240',
            'role'      => 'required',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/assets/dist/img'), $nama);
            $foto = $nama;
        }

        $user = User::create([
            'nama'       => $request->nama,
            'username'   => $request->username,
            'password'   => Hash::make($request->password),
            'foto'       => $foto,
        ]);

        $user->assignRole($request->role);
        if ($user) {
            return response()->json(['status' => true, 'message' => 'Berhasil menambahkan data User']);
        } else {
            return response()->json(['status' => false, 'message' => 'Berhasil menambahkan data User']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
        if ($request->ajax()) {
            $user = User::with('roles')->find($user->id);
            return response()->json(['status' => true, 'message' => '', 'data' => $user]);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($request->password == '' && $request->foto == '') {
            $this->validate($request, [
                'nama'      => 'required|max:25|min:3',
                'username'  => 'required|unique:users,username,' . $user->id,
                'role'      => 'required',
            ]);

        } else if ($request->password == '' && $request->foto != '') {
            $this->validate($request, [
                'nama'      => 'required|max:25|min:3',
                'username'  => 'required|unique:users,username,' . $user->id,
                'foto'      => 'required|mimes:jpg,jpeg,png|max:10240',
                'role'      => 'required',
            ]);

        } else if ($request->password != '' && $request->foto == '') {
            $this->validate($request, [
                'nama'      => 'required|max:25|min:3',
                'username'  => 'required|unique:users,username,' . $user->id,
                'password'  => ['required', 'same:password2', Password::min(5)->numbers()],
                'password2' => 'required',
                'role'      => 'required',
            ]);

        } else {
            $this->validate($request, [
                'nama'      => 'required|max:25|min:3',
                'username'  => 'required|unique:users,username,' . $user->id,
                'foto'      => 'required|mimes:jpg,jpeg,png|max:10240',
                'password'  => ['required', 'same:password2', Password::min(5)->numbers()],
                'password2' => 'required',
                'role'      => 'required',
            ]);
        }

        $user = User::findOrFail($user->id);
        if ($request->password == '' && $request->foto == '') {
            $user->update([
                'nama'        => $request->nama,
                'username'    => $request->username,
            ]);

            $user->syncRoles($request->role);

        } else if ($request->password == '' && $request->foto != '') {
            File::delete(public_path('/assets/dist/img/') . $user->foto);
            $file = $request->file('foto');
            $nama = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/assets/dist/img'), $nama);
            $foto = $nama;
            $user->update([
                'nama'        => $request->nama,
                'username'    => $request->username,
                'foto'        => $foto,
            ]);

            $user->syncRoles($request->role);

        } else if ($request->password != '' && $request->foto == '') {
            $user->update([
                'nama'        => $request->nama,
                'username'    => $request->username,
                'password'    => Hash::make($request->password),
            ]);

            $user->syncRoles($request->role);

        } else {
            File::delete(public_path('/assets/dist/img/') . $user->foto);
            $file = $request->file('foto');
            $nama = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/assets/dist/img'), $nama);
            $foto = $nama;
            $user->update([
                'nama'        => $request->nama,
                'username'    => $request->username,
                'foto'        => $foto,
                'password'    => Hash::make($request->password),
            ]);

            $user->syncRoles($request->role);
        }

        if ($user) {
            return response()->json(['status' => true, 'message' => 'Berhasil mengubah data User']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal mengubah data User']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        File::delete(public_path('/assets/dist/img/') . $user->foto);
        $user->delete();

        if ($user) {
            return response()->json(['status' => true, 'message' => 'Berhasil menghapus data User$user']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data User$user']);
        }
    }

    public function destroyBatch(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $id) {
                $user = User::findOrFail($id);
                File::delete(public_path('/assets/dist/img/') . $user->foto);
                $user->delete();
            }

            return response()->json(['status' => true, 'message' => 'Berhasil menghapus data User']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data User']);
        }
    }
}
