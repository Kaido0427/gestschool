<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Matiere;
use App\Models\Ue;
use App\Models\Mclass;
use App\Models\ClassMatiere;

class LoadData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = json_decode(file_get_contents(storage_path() . "/file.json"), true);

        foreach ($datas as $jsonData) {
            $ue="";
            $teacher="";
            $matiere="";
            if (array_key_exists("CODES", $jsonData)) {
                $ue= Ue::where('code', $jsonData["CODES"])->first();
                if (!$ue) {
                    if (array_key_exists("semestre", $jsonData) &&  array_key_exists("type", $jsonData)) {
                        if (array_key_exists("UE", $jsonData)) {
                            $ue = Ue::create([
                                "code" => $jsonData["CODES"],
                                "name"=> $jsonData["UE"],
                                "semestre"=> $jsonData["semestre"],
                                "type"=> $jsonData["type"]
                            ]);
                        } else {
                            $ue = Ue::create([
                                "code" => $jsonData["CODES"],
                                "name"=> $jsonData["ECU"],
                                "semestre"=> $jsonData["semestre"],
                                "type"=> $jsonData["type"]
                            ]);
                        }
                    } elseif (array_key_exists("type", $jsonData)) {
                        if (array_key_exists("UE", $jsonData)) {
                            $ue = Ue::create([
                                "code" => $jsonData["CODES"],
                                "name"=> $jsonData["UE"],
                                "type"=> $jsonData["type"]
                            ]);
                        } else {
                            $ue = Ue::create([
                                "code" => $jsonData["CODES"],
                                "name"=> $jsonData["ECU"],
                                "type"=> $jsonData["type"]
                            ]);
                        }
                    } elseif (array_key_exists("semestre", $jsonData)) {
                        if (array_key_exists("UE", $jsonData)) {
                            $ue = Ue::create([
                                "code" => $jsonData["CODES"],
                                "name"=> $jsonData["UE"],
                                "semestre"=> $jsonData["semestre"],
                            ]);
                        } else {
                            $ue = Ue::create([
                                "code" => $jsonData["CODES"],
                                "name"=> $jsonData["ECU"],
                                "semestre"=> $jsonData["semestre"],
                            ]);
                        }
                    }
                }
            } else {
                if (array_key_exists("UE", $jsonData)) {
                    $ue= Ue::where('name', $jsonData["UE"])->first();
                }
                if (!$ue) {
                    if (array_key_exists("semestre", $jsonData) &&  array_key_exists("type", $jsonData)) {
                        if (array_key_exists("UE", $jsonData)) {
                            $ue = Ue::create([
                                "name"=> $jsonData["UE"],
                                "semestre"=> $jsonData["semestre"],
                                "type"=> $jsonData["type"]
                            ]);
                        } else {
                            $ue = Ue::create([
                                "name"=> $jsonData["ECU"],
                                "semestre"=> $jsonData["semestre"],
                                "type"=> $jsonData["type"]
                            ]);
                        }
                    } elseif (array_key_exists("type", $jsonData)) {
                        if (array_key_exists("UE", $jsonData)) {
                            $ue = Ue::create([
                                "name"=> $jsonData["UE"],
                                "type"=> $jsonData["type"]
                            ]);
                        } else {
                            $ue = Ue::create([
                                "name"=> $jsonData["ECU"],
                                "type"=> $jsonData["type"]
                            ]);
                        }
                    } elseif (array_key_exists("semestre", $jsonData)) {
                        if (array_key_exists("UE", $jsonData)) {
                            $ue = Ue::create([
                                "name"=> $jsonData["UE"],
                                "semestre"=> $jsonData["semestre"],
                            ]);
                        } else {
                            $ue = Ue::create([
                                "name"=> $jsonData["ECU"],
                                "semestre"=> $jsonData["semestre"],
                            ]);
                        }
                    }
                }
            }


            if (array_key_exists("ENSEIGNANTS", $jsonData)) {
                $teacherName = explode(" ", $jsonData["ENSEIGNANTS"]);
                print_r($teacherName);
                //dd('teacherName', $teacherName[2]);
                $teacher = User::where('name', $teacherName[1])->orWhere('firstname', $teacherName[1])->first();
                if (!$teacher) {
                    $teacher = User::where('name', $teacherName[2])->orWhere('firstname', $teacherName[2])->first();
                }
            }
            if (array_key_exists("ECU", $jsonData)) {
                $matiere = Matiere::where('name', $jsonData["ECU"])->first();
            }

            if (!$matiere && array_key_exists("ECU", $jsonData)) {
                $matiere = Matiere::create(['name'=>$jsonData["ECU"], 'description'=> $jsonData["ECU"],'ue_id'=>$ue->id]);
            }
            $classe= Mclass::where('name', $jsonData["classe"])->first();

            if ($classe) {
                if ($teacher) {
                    $matiereByClasse = ClassMatiere::where('mclass_id', $classe->id)->where('matiere_id', $matiere->id)->first();
                    if (!$matiereByClasse) {
                        ClassMatiere::create([
                            "mclass_id"=>$classe->id,
                            "matiere_id"=>$matiere->id,
                            "user_id"=>$teacher->id
                        ]);
                    }
                } else {
                    if ($matiere && $classe) {
                        $matiereByClasse = ClassMatiere::where('mclass_id', $classe->id)->where('matiere_id', $matiere->id)->first();
                        if (!$matiereByClasse) {
                            ClassMatiere::create([
                                "mclass_id"=>$classe->id,
                                "matiere_id"=>$matiere->id,
                            ]);
                        }
                    }
                }
            }


            //echo $teacher;

            //$jsonData = json_encode($jsonData, JSON_PRETTY_PRINT);

            //echo $jsonData;

            //die();
        }
    }
}
