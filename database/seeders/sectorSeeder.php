<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class sectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("sectors")->insertMany([
            "name" => 'Informatique de gestion',
            "code" => 'IG',
        ],[
            "name" => 'mangement des ressources humaines',
            "code" => 'MRH',
        ]);
    }
}
