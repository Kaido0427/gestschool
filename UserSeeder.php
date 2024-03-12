<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Level;
use App\Models\Mclass;
use App\Models\Sector;
use App\Models\User;

use App\Mail\NotifyMail;
use Illuminate\Support\Facades\Mail;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // creation des filierers et des niveaux d'etudes
        $students = json_decode(file_get_contents(storage_path() . "/data.json"), true);

    //dd($students[0]);

     $filieres = [
        ["name" =>"Science du Mariage et de la famille", "code"=>"MFA"],
        ["name" =>"Psychologie et Science de l'Education", "code"=>"PSE"],
        ["name" =>"Science de la philosophie", "code"=>"PHILO"]
    ];

    //Sector::insert($filieres);

    $levels = [
        ["name"=>"Licence 1", "code" =>"L1"],
        ["name"=>"Licence 2", "code" =>"L2"],
        ["name"=>"Licence 3", "code" =>"L3"],
        ["name"=>"Licence Canonique 1", "code" =>"LC1"],
        ["name"=>"Licence Canonique 2", "code" =>"LC2"],
        ["name"=>"Master 1", "code" =>"M1"],
        ["name"=>"Master 2", "code" =>"M2"],
        ["name"=>"Doctorat 1", "code" =>"D1"],
        ["name"=>"Doctorat 2", "code" =>"D2"],
        ["name"=>"Doctorat 3", "code" =>"D3"],
        ["name"=>"Doctorat 4", "code" =>"D4"]
    ];

    //Level::insert($levels);

   // $getFiliere = Sector::all();

/*     foreach($getFiliere as $filiere){
        $getLevels = Level::all();
        foreach ($getLevels as $level) {
            
            if ($filiere['code'] =="MFA" && $level["code"]=="L1") {
                
                $class = Mclass::create(["name"=>"LU1", "sector_id"=>$filiere["id"], "level_id" =>$level["id"]]);
            } else
            if ($filiere['code'] =="MFA" && $level["code"]=="L2") {
                
                $class = Mclass::create(["name"=>"LU2", "sector_id"=>$filiere["id"], "level_id" =>$level["id"]]);
            }
            
           else if ($filiere['code'] =="MFA" && $level["code"]=="L3") {
                
                $class = Mclass::create(["name"=>"LU3", "sector_id"=>$filiere["id"], "level_id" =>$level["id"]]);
            }

           else if ($filiere['code'] =="MFA" && $level["code"]=="M1") {
                
                $class = Mclass::create(["name"=>"MFA1", "sector_id"=>$filiere["id"], "level_id" =>$level["id"]]);
            }

            else if ($filiere['code'] =="MFA" && $level["code"]=="M2") {
                
                $class = Mclass::create(["name"=>"MFA2", "sector_id"=>$filiere["id"], "level_id" =>$level["id"]]);
            }

            else if ($filiere['code'] =="MFA" && $level["code"]=="LC1") {
                
                $class = Mclass::create(["name"=>"LC1", "sector_id"=>$filiere["id"], "level_id" =>$level["id"]]);
            }

            else if ($filiere['code'] =="MFA" && $level["code"]=="LC2") {
                
                $class = Mclass::create(["name"=>"LC2", "sector_id"=>$filiere["id"], "level_id" =>$level["id"]]);
            }

            else if ($filiere['code'] =="PSE" && $level["code"]=="L1") {
                
                $class = Mclass::create(["name"=>"LF1", "sector_id"=>$filiere["id"], "level_id" =>$level["id"]]);
            } else
            if ($filiere['code'] =="PSE" && $level["code"]=="L2") {
                
                $class = Mclass::create(["name"=>"LF2", "sector_id"=>$filiere["id"], "level_id" =>$level["id"]]);
            }
            
           else if ($filiere['code'] =="PSE" && $level["code"]=="L3") {
                
                $class = Mclass::create(["name"=>"LF3", "sector_id"=>$filiere["id"], "level_id" =>$level["id"]]);
            }


            else if ($filiere['code'] =="PSE" && $level["code"]=="M1") {
                
                $class = Mclass::create(["name"=>"PSE1", "sector_id"=>$filiere["id"], "level_id" =>$level["id"]]);
            } 

            else if ($filiere['code'] =="PSE" && $level["code"]=="M2") {
                
                $class = Mclass::create(["name"=>"SE2", "sector_id"=>$filiere["id"], "level_id" =>$level["id"]]);
            } 

        }
    }
  */

        foreach($students as $student){
            
            echo '____________________________________________________________________________';

                echo $student["Classe"];
            echo '______________________________________________________________________________';
            $myuser; 
            if (array_key_exists('Classe', $student)) {
                $class = Mclass::where('name', $student["Classe"])->first();
                echo '---------------------------------------------------------------------'; 
                echo '---------------------------------------------------------------------'; 
                echo $class; 
                echo '---------------------------------------------------------------------'; 
                echo '---------------------------------------------------------------------'; 
                if (array_key_exists('Email', $student) && array_key_exists('Contact', $student) ) {
                    $myuser =   User::create([
                        "name" => $student["Nom"],
                        "email"=> $student["Email"],
                        "firstname"=>$student["Prenoms"],
                        "phone"=>$student["Contact"],
                        "matricule"=>$student["Matricule"],
                        "is_active"=>true,
                        "mclasse_id"=>$class->id,
                        "address" =>$student["Contact"],
                        "password" =>"Etudi@nt"
                    ]); 
                }else if (array_key_exists('Email', $student)) {
                    User::create([
                        "name" => $student["Nom"],
                        "email"=> $student["Email"],
                        "firstname"=>$student["Prenoms"],
                        "matricule"=>$student["Matricule"],
                        "is_active"=>true,
                        "mclasse_id"=>$class->id,
                        "password" =>"Etudi@nt"
                    ]);            
                }

                if (array_key_exists('Email', $student)) {

                    $myuser["password"] = "Etudi@nt"; 

                   // $mail= Mail::to($student["Email"])->send(new NotifyMail($myuser));

                    //echo $mail;
                }
            }

        }            
        
    }

}
