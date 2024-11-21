<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Image;
use Illuminate\Support\Facades\DB;

class ProductosOficinaSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            // Obtener el usuario vendedor por su correo
            $user = User::where('email', 'b.armyforever333@gmail.com')->first();

            if (!$user) {
                $this->command->info("No se encontró un usuario con el correo 'b.armyforever333@gmail.com'.");
                return;
            }
            // Obtener el ID de la categoría 'Coleccionables' por su nombre
            $categoria = Categoria::where('nombre', 'Oficina')->first();

            if (!$categoria) {
                $this->command->info("No se encontró la categoría 'Oficna'. Asegúrate de tener esa categoría en la base de datos.");
                return;
            }
            // Crear productos para el usuario en la categoría 'Coleccionables'
            $productos = [
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 1
                    'nombre' => 'Cuaderno de vaca',
                    'descripcion' => 'Libreta profesional',
                    'precio' => 99.99,
                    'stock' => 40,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/oficina/a1.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 2
                    'nombre' => 'Plumas de vaca',
                    'descripcion' => 'Paquete de 10',
                    'precio' => 170.00,
                    'stock' => 39,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/oficina/b1.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 3
                    'nombre' => 'Sacapuntas de vaca',
                    'descripcion' => '4 piezas',
                    'precio' => 140.00,
                    'stock' => 31,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/oficina/c1.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 4
                    'nombre' => 'Lapicera de vaca',
                    'descripcion' => '25 cm x 10 cm x 11 cm',
                    'precio' => 209.00,
                    'stock' => 29,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/oficina/d1.jpg']
                ],
            ];

            foreach ($productos as $productoData) {
                // Crear el producto
                $imagenes = $productoData['imagenes'];
                unset($productoData['imagenes']); // Elimina las imágenes del array de producto antes de guardar

                $producto = Producto::create($productoData);
                // Crear cada imagen asociada a este producto
                foreach ($imagenes as $imagen) {
                    Image::create([
                        'producto_id' => $producto->id,
                        'path' => $imagen,
                    ]);
                }
            }
        });
    }
}
