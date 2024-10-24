<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Juan Perez',
            'email' => 'juan@example.com',
            'password' => bcrypt('password'),
            'role' => 'vendedor', // Asignar rol de vendedor
        ]);

        User::create([
            'name' => 'Maria Gomez',
            'email' => 'maria@example.com',
            'password' => bcrypt('password'),
            'role' => 'comprador', // Asignar rol de comprador
        ]);

        // Puedes añadir más usuarios si es necesario
    }
}
