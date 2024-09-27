<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('general_settings')->insert([
            'logo' => '123',
            'mobile' => '123',
            'fb' => '123',
            'address' => '123',
            'host' => '123',
            'email' => '123',
            'password' => '123',
            'policy' => '123',
        ]);
    }
}
