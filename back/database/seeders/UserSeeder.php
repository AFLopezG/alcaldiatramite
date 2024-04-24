<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            ["cedula"=>"000001","name"=>"Administrador","email"=>"admin@test.com",'password'=>Hash::make('admin123Admin'),"fechalimite"=>"2999-12-31","cargo"=>"ADMINISTRADOR","cargo_id"=>1],
        ]);
    }
}
