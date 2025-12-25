<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("INSERT INTO departs(depart_no, dnombre, loc) VALUES (10,'CONTABILIDAD','SEVILLA');");
        DB::statement("INSERT INTO departs(depart_no, dnombre, loc) VALUES (20,'INVESTIGACION','MADRID');");
        DB::statement("INSERT INTO departs(depart_no, dnombre, loc) VALUES (30,'VENTAS','BARCELONA');");
        DB::statement("INSERT INTO departs(depart_no, dnombre, loc) VALUES (40,'PRODUCCION','BILBAO');");
    }
}
