<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspecialidadSeeder extends Seeder
{
    public function run()
    {
        DB::table('especialidades')->insert([
            ['nombre' => 'Medicina General'],
            ['nombre' => 'Cardiología'],
            ['nombre' => 'Dermatología'],
            ['nombre' => 'Pediatría'],
            ['nombre' => 'Neurología'],
            ['nombre' => 'Ginecología'],
            ['nombre' => 'Ortopedia'],
            ['nombre' => 'Oftalmología'],
            ['nombre' => 'Psiquiatría'],
            ['nombre' => 'Endocrinología'],
            ['nombre' => 'Reumatología'],
            ['nombre' => 'Oncología'],
            ['nombre' => 'Nefrología'],
            ['nombre' => 'Anestesiología'],
            ['nombre' => 'Traumatología'],
        ]);
    }
}

