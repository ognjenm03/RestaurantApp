<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::create([
            'full_name'    => 'Admin Adminović',
            'username'     => 'admin',
            'email'        => 'admin@restoran.com',
            'password'     => Hash::make('admin123'),
            'user_type_id' => 1,
        ]);

        // Kreiraj jednog konobara ručno
        User::create([
            'full_name'    => 'Pera Konobar',
            'username'     => 'konobar',
            'email'        => 'konobar@restoran.com',
            'password'     => Hash::make('konobar123'),
            'user_type_id' => 2,
        ]);
    }
}
