<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pais;

class PaisSeeder extends Seeder
{
    public function run()
    {
        $paises = [
            'Argentina',
            'Belice',
            'Bolivia',
            'Brasil',
            'Canadá',
            'Chile',
            'Colombia',
            'Costa Rica',
            'Ecuador',
            'El Salvador',
            'España',
            'Estados Unidos',
            'Francia',
            'Guatemala',
            'Honduras',
            'México',
            'Nicaragua',
            'Panamá',
            'Paraguay',
            'Perú',
            'Surinam',
            'Trinidad y Tobago',
            'Reino Unido',
            'Uruguay',
            'Venezuela',
            'Alemania',
            'Italia',
            'Portugal',
            'Japón',
            'Australia',
            'China',
            'India',
            'Sudáfrica',
            'Rusia',
            'Suecia',
            'Noruega',
            'Suiza',
            'Países Bajos',
            'Bélgica',
            'Austria',
            'Dinamarca',
            'Finlandia',
            'Grecia',
            'Hungría',
            'República Checa',
            'Irlanda',
            'Nueva Zelanda',
        ];

        foreach ($paises as $nombre) {
            Pais::firstOrCreate(['nombre' => $nombre]);
        }
    }
}
