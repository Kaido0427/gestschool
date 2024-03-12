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
            "email"=> "administrateur@gmail.com",
            "name"=> "Savplus Dev",
            "password"=> "@lelua77",
            "phone"=> "12987653432",
            "address"=> "Cadjêhoun",
            "type"=> "admin",
            "mclasse_id"=>2,
        ]);
    }
}
