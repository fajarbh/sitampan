<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nik' => '3214567890111213',
            'no_hp' => '085883570638',
            'password' => bcrypt('12345678'),
            'is_verified' => true,
            'level' => 1,
        ]);
    }
}
