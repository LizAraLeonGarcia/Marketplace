<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersTableSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // para los usuarios
            RegistrarUsuariosSeeder::class,
            // cargar los paises
            PaisSeeder::class,
            // cargar las categorias
            CategoriaSeeder::class,
            // para los productos
            Producto1Seeder::class,
            Producto2Seeder::class,
            Producto3Seeder::class,
            Producto4Seeder::class,
            ProductosAccesoriosSeeder::class,
            ProductosCalzadoSeeder::class,
            ProductosCocinaSeeder::class,
            ProductosEscolarSeeder::class,
            ProductosHogarSeeder::class,
            ProductosOficinaSeeder::class,
            ProductosRopaSeeder::class,
            ProductosVideojuegosSeeder::class,
        ]);
    }
}
