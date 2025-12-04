<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GrupoSanguineoSeeder extends Seeder
{
    public function run()
    {
        DB::table('grupos_sanguineos')->insert([
            ['tipo' => 'A+'],
            ['tipo' => 'A-'],
            ['tipo' => 'B+'],
            ['tipo' => 'B-'],
            ['tipo' => 'O+'],
            ['tipo' => 'O-'],
            ['tipo' => 'AB+'],
            ['tipo' => 'AB-'],
        ]);
    }
}
