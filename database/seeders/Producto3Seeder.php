<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Image;
use Illuminate\Support\Facades\DB;

class Producto3Seeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            // Obtener el usuario vendedor por su correo
            $user = User::where('email', 'rusherforever777@gmail.com')->first();

            if (!$user) {
                $this->command->info("No se encontró un usuario con el correo 'rusherforever777@gmail.com'.");
                return;
            }
            // Obtener el ID de la categoría 'Coleccionables' por su nombre
            $categoria = Categoria::where('nombre', 'Coleccionables')->first();

            if (!$categoria) {
                $this->command->info("No se encontró la categoría 'Coleccionables'. Asegúrate de tener esa categoría en la base de datos.");
                return;
            }
            // Crear productos para el usuario en la categoría 'Coleccionables'
            $productos = [
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 1
                    'nombre' => 'Street Fighter Vega',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 499.99,
                    'stock' => 31,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/a1.jpg', 'img/productos/coleccionables/favoritos/a2.jpg', 'img/productos/coleccionables/favoritos/a3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 2
                    'nombre' => 'Street Fighter Ryu',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 399.00,
                    'stock' => 40,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/b1.jpg', 'img/productos/coleccionables/favoritos/b2.jpg', 'img/productos/coleccionables/favoritos/b3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 3
                    'nombre' => 'Street Fighter Charlie Nash',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 519.00,
                    'stock' => 30,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/c1.jpg', 'img/productos/coleccionables/favoritos/c2.jpg', 'img/productos/coleccionables/favoritos/c3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 4
                    'nombre' => 'Street Fighter Zeku',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 569.00,
                    'stock' => 24,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/d1.jpg', 'img/productos/coleccionables/favoritos/d2.jpg', 'img/productos/coleccionables/favoritos/d3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 5
                    'nombre' => 'Street Fighter Sagat',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 449.96,
                    'stock' => 28,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/e1.jpg', 'img/productos/coleccionables/favoritos/e2.jpg', 'img/productos/coleccionables/favoritos/e3.jpg']
                ],
                [ // ----------------------------------------------------------------------------------------------------------------- PRODUCTO 6
                    'nombre' => 'Street Fighter Rashid',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 439.00,
                    'stock' => 25,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/f1.jpg', 'img/productos/coleccionables/favoritos/f2.jpg', 'img/productos/coleccionables/favoritos/f3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 7
                    'nombre' => 'Street Fighter Kage',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 469.00,
                    'stock' => 20,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/g1.jpg', 'img/productos/coleccionables/favoritos/g2.jpg', 'img/productos/coleccionables/favoritos/g3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 8
                    'nombre' => 'Street Fighter Ed',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 449.00,
                    'stock' => 22,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/h1.jpg', 'img/productos/coleccionables/favoritos/h2.jpg', 'img/productos/coleccionables/favoritos/h3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 9
                    'nombre' => 'Street Fighter Cody',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 389.00,
                    'stock' => 29,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/i1.jpg', 'img/productos/coleccionables/favoritos/i2.jpg', 'img/productos/coleccionables/favoritos/i3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 10
                    'nombre' => 'Street Fighter Remy',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 459.00,
                    'stock' => 23,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/j1.jpg', 'img/productos/coleccionables/favoritos/j2.jpg', 'img/productos/coleccionables/favoritos/j3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 11
                    'nombre' => 'Street Fighter Guy',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 379.00,
                    'stock' => 28,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/k1.jpg', 'img/productos/coleccionables/favoritos/k2.jpg', 'img/productos/coleccionables/favoritos/k3.jpg']
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
