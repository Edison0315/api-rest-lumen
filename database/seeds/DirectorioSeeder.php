<?php

use Illuminate\Database\Seeder;

class DirectorioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('directorios')->insert([
            [
                'nombre_completo' => 'Edisson Bedoya',
                'direccion'       => 'Cra 1 # 11 - 41',
                'telefono'        => '123456789',
                'url_foto'        => null,
            ],
            [
                'nombre_completo' => 'Ingrid eliana',
                'direccion'       => 'Cra 1 # 10 - 10',
                'telefono'        => '99658787',
                'url_foto'        => null,
            ],
        ]);
    }
}
