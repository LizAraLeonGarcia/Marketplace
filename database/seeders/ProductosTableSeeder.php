<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto; // Asegúrate de importar el modelo Producto

class ProductosTableSeeder extends Seeder
{
    public function run()
    {
        Producto::create([
            'nombre' => 'Producto 1',
            'stock' => 10,
            'precio' => 100.00,
            'vendedor_id' => 1, // Asegúrate de que este ID exista
            // Otros campos según tu modelo
        ]);

        Producto::create([
            'nombre' => 'Producto 2',
            'stock' => 5,
            'precio' => 200.00,
            'vendedor_id' => 1,
        ]);
    }
}
