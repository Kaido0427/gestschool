<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class adminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::Create([
            "email"=> "admin@gestschool.com",
            "name"=> "admin",
            "password"=> "@dmin2022",
            "phone"=> "098765432",
            "address"=> "Cadjêhoun",
            "type"=> "admin"
        ]);
    }
}
