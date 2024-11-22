<?php

namespace Database\Factories;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->word, // Generar un nombre aleatorio
            'descripcion' => $this->faker->sentence, // Descripción aleatoria
            'precio' => $this->faker->randomFloat(2, 10, 1000), // Precio entre 10 y 1000
            'stock' => $this->faker->numberBetween(1, 100), // Stock entre 1 y 100
            'categoria_id' => Categoria::factory(), // Crear una categoría asociada
        ];
    }
}
