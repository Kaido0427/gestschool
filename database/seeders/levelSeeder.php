<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class levelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("levels")->insertMany([
            "name" => 'Première année de licence',
            "code" => 'L1',
        ],[
            "name" => 'deuxième année de licence',
            "code" => 'L2',
        ],[
            "name" => 'troisième année de licence',
            "code" => 'L3',
        ]);
    }
}
