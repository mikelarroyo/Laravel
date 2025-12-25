<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("
            INSERT INTO products (nombre, descripcion, precio)
            VALUES
                ('Zapatillas Running Pro', 'Zapatillas deportivas diseñadas para running en asfalto, ligeras y cómodas.', 89.99),
                ('Camiseta Técnica DryFit', 'Camiseta transpirable ideal para entrenamientos intensos y actividades al aire libre.', 19.95),
                ('Mochila Deportiva 30L', 'Mochila resistente con múltiples compartimentos para gimnasio o viajes cortos.', 45.50),
                ('Botella Térmica Acero', 'Botella térmica de acero inoxidable que mantiene bebidas frías o calientes.', 14.90),
                ('Auriculares Inalámbricos', 'Auriculares bluetooth con cancelación de ruido y gran autonomía.', 59.99),
                ('Reloj Deportivo Smart', 'Reloj inteligente con monitor de actividad, pulsómetro y GPS integrado.', 129.00),
                ('Esterilla Yoga Antideslizante', 'Esterilla cómoda y antideslizante para yoga, pilates y estiramientos.', 22.75),
                ('Pesas Ajustables 20kg', 'Juego de pesas ajustables ideal para entrenar fuerza en casa.', 99.50),
                ('Sudadera Training Unisex', 'Sudadera cómoda y resistente para entrenamientos o uso diario.', 34.90),
                ('Guantes Fitness', 'Guantes acolchados para proteger las manos durante el entrenamiento de fuerza.', 12.00);
        ");
    }
}
