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

        return view('dashboard.data', compact(['cafe', 'kategori', 'menu']))->with('title', 'Dashboard');

    }
}
