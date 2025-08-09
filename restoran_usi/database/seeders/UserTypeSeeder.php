<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_types')->insert([
            [
                'user_type_id' => 1,
                'type_name' => 'Admin',
            ],
            [
                'user_type_id' => 2,
                'type_name' => 'Konobar',
            ],
        ]);
    }
}
