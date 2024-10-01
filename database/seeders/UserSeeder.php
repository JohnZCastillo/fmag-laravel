<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'User',
                'email' => 'admin@fmag.shop',
                'password' => bcrypt('password123'),
                'email_verified_at' => Carbon::now()->format('Y-m-d H:m'),
                'completed' => true,
                'verified' => true,
            ],
            [
                'name' => 'User',
                'email' => 'user@fmag.shop',
                'password' => bcrypt('password123'),
                'email_verified_at' => Carbon::now()->format('Y-m-d H:m'),
                'completed' => true,
                'verified' => true,
            ],
        ]);

    }
}
