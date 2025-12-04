<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EfectoSeeder extends Seeder
{
    public function run()
    {
        DB::table('efectos')->insert([
            ['nombre' => 'Analgésico'],
            ['nombre' => 'Antiinflamatorio'],
            ['nombre' => 'Antibiótico'],
            ['nombre' => 'Antihistamínico'],
            ['nombre' => 'Anestésico'],
            ['nombre' => 'Antipirético'],
            ['nombre' => 'Antidepresivo'],
            ['nombre' => 'Ansiolítico'],
            ['nombre' => 'Diurético'],
            ['nombre' => 'Anticoagulante'],
        ]);
    }
}
