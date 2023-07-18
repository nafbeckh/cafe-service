<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Pelanggan;
use App\Models\Kategori;
use App\Models\Menu;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $cafe = Setting::first();
        $pelanggan = Pelanggan::count();
        $kategori = Kategori::count();
        $menu = Menu::count();
        $user = User::count();

        if (auth()->user()->hasRole('admin')) {
            return view('dashboard.data', compact(['cafe', 'pelanggan', 'kategori', 'menu', 'user']))->with('title', 'Dashboard');
        } else if (auth()->user()->hasRole('chef')) {
            return redirect()->intended('pesanan');
        } else if (auth()->user()->hasRole('waiter')) {
            return redirect()->intended('pesanan/meja');
        }
    }
}
