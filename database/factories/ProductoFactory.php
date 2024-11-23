<?php

namespace Database\Factories;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\User; // Asegúrate de importar User
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->word,
            'descripcion' => $this->faker->sentence,
            'precio' => $this->faker->randomFloat(2, 10, 1000),
            'stock' => $this->faker->numberBetween(1, 100),
            'categoria_id' => Categoria::factory(),
            'user_id' => User::factory(), // Asegúrate de que se esté creando un usuario
        ];
    }
}
