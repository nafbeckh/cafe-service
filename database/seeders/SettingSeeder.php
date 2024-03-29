<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'nama_cafe'   => 'Cafe Service',
            'alamat'      => 'Jl. Jendral Sudirman',
            'diskon'      => 0,
            'per_pesanan' => 0,
            'path_logo'   => 'logo-20230610091921.png'
        ]);
    }
}
