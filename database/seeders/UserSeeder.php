<?php

namespace Database\Seeders;

use App\Enums\UserRole;
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
                'id' => 1,
                'name' => 'User',
                'email' => 'admin@fmag.shop',
                'password' => bcrypt('admin'),
                'email_verified_at' => Carbon::now()->format('Y-m-d H:m'),
                'completed' => true,
                'verified' => true,
                'role' => UserRole::ADMIN
            ],
        ]);

    }
}
