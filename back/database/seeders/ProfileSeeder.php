<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('profiles')->insert([
            ["prof"=>"ADMINISTRADOR"],
            ["prof"=>"JEFATURA"],
            ["prof"=>"VENTANILLA UNICA"],
            ["prof"=>"COORDINADOR"],
            ["prof"=>"LIQUIDACION"],
            ["prof"=>"CODIFICACION"],
            ["prof"=>"TOPOGRAFO"],
            ["prof"=>"CERTIFICACION"],
            ["prof"=>"LEGALIZACION"],
            ["prof"=>"ASESOR LEGAL"],
            ["prof"=>"ARCHIVO"],
        ]);
    }
}
