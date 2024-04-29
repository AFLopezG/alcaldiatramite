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
            ["cedula"=>"000001","name"=>"Administrador","email"=>"admin@test.com",'password'=>Hash::make('admin123Admin'),"fechalimite"=>"2999-12-31","cargo_id"=>1,"unit_id"=>24],
            ["cedula"=>"7392049","name"=>"Arq.Maribel Ventura Rafael","email"=>"mventura@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2023-12-31","cargo_id"=>3,"unit_id"=>34],
            ["cedula"=>"2723229","name"=>"Danny Raquel Jaimes","email"=>"draquel@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2023-12-31","cargo_id"=>13,"unit_id"=>34],
            ["cedula"=>"0000002","name"=>"AUXILIAR","email"=>"auxiliar@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2023-12-31","cargo_id"=>6,"unit_id"=>34],
            ["cedula"=>"0000003","name"=>"AUXILIAR 2","email"=>"auxiliar2@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2023-12-31","cargo_id"=>10,"unit_id"=>34],
            ["cedula"=>"2720015","name"=>"Abraham Condarco Soliz","email"=>"acondarco@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2023-12-31","cargo_id"=>12,"unit_id"=>34],
            ["cedula"=>"3091881","name"=>"William Gascon Alcazar","email"=>"wgaston@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2023-12-31","cargo_id"=>8,"unit_id"=>34],
            ["cedula"=>"2767924","name"=>"Walter Aguilar Marquez","email"=>"waguilar@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2023-12-31","cargo_id"=>4,"unit_id"=>34],
            ["cedula"=>"2763625","name"=>"Heriberto Guzman Ayala","email"=>"hguzman@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2023-12-31","cargo_id"=>7,"unit_id"=>34],
            ["cedula"=>"5067196","name"=>"Arq. Mirian Villalobos","email"=>"mvillalobos@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2023-12-31","cargo_id"=>11,"unit_id"=>34],
            ["cedula"=>"4049066","name"=>"Arq. Betty Michaga Mamani","email"=>"bmichaga@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2023-12-31","cargo_id"=>11,"unit_id"=>34],
            ["cedula"=>"669813","name"=>"Abdon Cussi Flores","email"=>"acussi@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2023-12-31","cargo_id"=>9,"unit_id"=>34],
            ["cedula"=>"7281306","name"=>"Arq. Patricia Villarte Mamani","email"=>"pvillarte@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2023-12-31","cargo_id"=>5,"unit_id"=>34],
            ["cedula"=>"5740826","name"=>"Arq. Monica Condori Valdez","email"=>"mcondori@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2023-12-31","cargo_id"=>5,"unit_id"=>34],
            ["cedula"=>"3552555","name"=>"Arq. Minerva Villarroel Lujan","email"=>"mvillarroel@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2023-12-31","cargo_id"=>5,"unit_id"=>34],
            ["cedula"=>"0000004","name"=>"Carlos Mamani Llave","email"=>"cmamani@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2023-12-31","cargo_id"=>2,"unit_id"=>34],
            ["cedula"=>"0000005","name"=>"Ariel Canqui Bellot","email"=>"acanqui@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2023-12-31","cargo_id"=>2,"unit_id"=>34],
            ["cedula"=>"7268803","name"=>"Dr. Sergio Pinaya Choque","email"=>"spinaya@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2023-12-31","cargo_id"=>14,"unit_id"=>34],
            
            ["cedula"=>"5759430","name"=>"Arq. Gilmar Mamani Morales","email"=>"gmamani@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2024-12-31","cargo_id"=>15,"unit_id"=>28],
            ["cedula"=>"7334917","name"=>"Arq. Nataly Jhannet Cruz","email"=>"ncruz@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2024-12-31","cargo_id"=>5,"unit_id"=>28],
            ["cedula"=>"7310138","name"=>"Arq. Maribel Luna Arroja","email"=>"mluna@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2024-12-31","cargo_id"=>5,"unit_id"=>28],
            ["cedula"=>"7297095","name"=>"Arq. Palmira Colque Gonzales","email"=>"pcolque@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2024-12-31","cargo_id"=>5,"unit_id"=>28],
            ["cedula"=>"5766816","name"=>"Arq. Helen Mariela Ugarte Valencia","email"=>"hugarte@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2024-12-31","cargo_id"=>5,"unit_id"=>28],
            ["cedula"=>"5762485","name"=>"Ing. Adolfo Flores Vargas","email"=>"aflores@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2024-12-31","cargo_id"=>17,"unit_id"=>28],
            ["cedula"=>"0000111","name"=>"Abg. Sandra Choque","email"=>"schoque@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2024-12-31","cargo_id"=>14,"unit_id"=>28],
            ["cedula"=>"5735933","name"=>"Abg. Reynaldo Borges Colque","email"=>"rborges@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2024-12-31","cargo_id"=>14,"unit_id"=>28],
            ["cedula"=>"3101679","name"=>"Teofilo Mendoza Lopez","email"=>"tmendoza@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2024-12-31","cargo_id"=>7,"unit_id"=>28],
            ["cedula"=>"629670","name"=>"Andres Fernandez Yucra","email"=>"afernandez@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2024-12-31","cargo_id"=>18,"unit_id"=>28],
            ["cedula"=>"3535494","name"=>"Arq. Karina Lourdes Brañez Ponce","email"=>"kbranez@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2024-12-31","cargo_id"=>5,"unit_id"=>28],
            ["cedula"=>"4075600","name"=>"Arq. Freddy Mollo Mollo","email"=>"fmollo@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2024-12-31","cargo_id"=>5,"unit_id"=>28],
            ["cedula"=>"35444407","name"=>"Arq. Heidi Marcela Nicolas Magne","email"=>"hnicolas@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2024-12-31","cargo_id"=>5,"unit_id"=>28],
            ["cedula"=>"3534902","name"=>"Abg. Claudia Melby Llanque Ramirez","email"=>"cllanque@gamo.com",'password'=>Hash::make('123456'),"fechalimite"=>"2024-12-31","cargo_id"=>14,"unit_id"=>28],
    
        ]);
    }
}
