<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'nama' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'foto' => 'avatar.png'
        ]);

        $admin->assignRole('admin');
    }
}
