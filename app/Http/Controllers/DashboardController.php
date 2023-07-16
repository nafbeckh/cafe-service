<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Kategori;
use App\Models\Menu;

class DashboardController extends Controller
{
    public function index()
    {
        $cafe = Setting::first();
        $kategori = Kategori::count();
        $menu = Menu::count();

        if (auth()->user()->hasRole('admin')) {
            return view('dashboard.data', compact(['cafe', 'kategori', 'menu']))->with('title', 'Dashboard');
        } else if (auth()->user()->hasRole('chef')) {
            return redirect()->intended('pesanan');
        } else if (auth()->user()->hasRole('waiter')) {
            return redirect()->intended('pesanan/meja');
        }
    }
}
