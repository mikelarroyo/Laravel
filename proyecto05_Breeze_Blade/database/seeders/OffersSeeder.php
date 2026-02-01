<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OffersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('offers')->insert([
            "date_delivery" => "2026-01-25",
            "time_delivery" => "14:00:05",
            "datetime_limit" => "2026-01-24 14:50:50",
        ]);
    }
}
