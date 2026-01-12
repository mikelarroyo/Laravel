<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <--- Importante para usar DB::insert

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::insert("INSERT INTO products (name, description, price, available, product_type, image, date, time, created_at, updated_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())", [
            'Menú Martes 2 de Diciembre',
            '1º: Pastel de Patata. 2º: Solomillo de cerdo Stroganoff. Postre: Pavlova de frutos rojos.',
            8.00,
            true,
            'menu',
            'uploads/menu1.jpg',
            '2025-12-02',
            '13:35 a 14:30'
        ]);
    }
}
