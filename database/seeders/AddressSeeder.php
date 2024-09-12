<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file_path = resource_path('sql/address.sql');

        DB::unprepared(
            file_get_contents($file_path)
        );
    }
}
