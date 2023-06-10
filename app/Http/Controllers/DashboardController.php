<?php

namespace App\Http\Controllers;

use App\Models\Setting;

class DashboardController extends Controller
{
    public function index()
    {
        $cafe = Setting::first();

        return view('dashboard.data', compact(['cafe']))->with('title', 'Dashboard');

    }
}
