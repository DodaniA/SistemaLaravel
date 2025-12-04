<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ViaAdministracionSeeder extends Seeder
{
    public function run()
    {
        DB::table('vias_administracion')->insert([
            ['nombre' => 'Oral'],
            ['nombre' => 'Intravenosa'],
            ['nombre' => 'Intramuscular'],
            ['nombre' => 'Subcutánea'],
            ['nombre' => 'Tópica'],
            ['nombre' => 'Sublingual'],
            ['nombre' => 'Rectal'],
            ['nombre' => 'Inhalatoria'],
            ['nombre' => 'Nasal'],
        ]);
    }
}
