<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["slug"=>"create_students","description"=>"Enregistrer un étudiant",],
            ["slug"=>"update_students","description"=>"Mettre à jour un etudiant"],
            
            ["slug"=>"create_teachers","description"=>"Enregistrer un enseignant",],
            ["slug"=>"update_teachers","description"=>"Mettre à jour un enseignant"],

            ["slug"=>"create_levels","description"=>" Enregistrer un niveau d'étude"],
            ["slug"=>"update_levels","description"=>" Mettre  à jour un niveau d'étude"],
            ["slug"=>"update_matieres","description"=>" Mettre à jour une matière"],
            ["slug"=>"create_matieres","description"=>" Ajouter une matière"],
            ["slug"=>"create_sectors","description"=>" Ajouter une filière"],
            ["slug"=>"update_sectors","description"=>" Mettre à jour une filière"],
            ["slug"=>"update_notes","description"=>" Mettre à jour une note"],
            ["slug"=>"add_notes","description"=>"Ajouter une note"],
            ["slug"=>"create_promotions","description"=>"Ajouter une promotion"],
            ["slug"=>"update_promotions","description"=>"Mettre à jour une promotion"],
            ["slug"=>"update_classes","description"=>"Editer une classe"],
            ["slug"=>"create_classes","description"=>"Ajouter une classe"],
            ["slug"=>"create_personals","description"=>"Ajouter un personnel"],
            ["slug"=>"update_personals","description"=>"Mettre à jour  un personnel"],

        ];

        if (!count(Role::all())) {
            Role::insert($data);
        }
    }
}
