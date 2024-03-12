<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class teacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!count(User::where('type', 'teacher')->get())) {
            # code...
            $teachers = json_decode(file_get_contents(storage_path() . "/teacher.json"), true);
            $i = 0;
            foreach ($teachers as $teacher) {
                if (array_key_exists("MAIL", $teacher)) {
                    $user = User::where('email', $teacher["MAIL"])->first();
                    if (!$user) {
                        # code...
                        if (array_key_exists("GRADE", $teacher)) {
                            User::create([
                                "name" => $teacher["NOM"],
                                "email" => $teacher["MAIL"],
                                "firstname" => $teacher["PRENOM"],
                                "phone" => $teacher["CONTACT"],
                                "is_active" => true,
                                "type" => 'teacher',
                                "address" => $teacher["CONTACT"],
                                "consegration" => $teacher["CONSECRATION"],
                                "statut" => $teacher["STATUT"],
                                "grade" => $teacher["GRADE"],
                                "password" => "Pr@fesseur"
                            ]);
                            $name = $teacher['NOM'];
                            var_dump("le professeur $name est enregistrer");
                        } else {

                            User::create([
                                "name" => $teacher["NOM"],
                                "email" => $teacher["MAIL"],
                                "firstname" => $teacher["PRENOM"],
                                "phone" => $teacher["CONTACT"],
                                "is_active" => true,
                                "type" => 'teacher',
                                "address" => $teacher["CONTACT"],
                                "consegration" => $teacher["CONSECRATION"],
                                "statut" => $teacher["STATUT"],
                                "password" => "Pr@fesseur"
                            ]);
                            $name = $teacher['NOM'];

                            var_dump("le professeur $name est enregistrer");
                        }
                    }
                }
            }
        }
    }
}
