<?php

namespace App\Helpers;

use App\Models\MatiereTeacher;
use App\Models\Promotion;
use Carbon\Carbon;

class NextPromotion
{
    public static function nextPromotion()
    {
        // je récupere le nom de la promotion actuel
        
        $currentPromotion = Promotion::where('status', 'In_progress')->first();

        $currentPromotionName = $currentPromotion["name"];

        // je split le name et je récupere l'année superieur
        $superieurYearCurrentPromotion = explode("-", $currentPromotionName)[1];

        $nextSuperieurYear = intval($superieurYearCurrentPromotion) + 1;
    
        $nextPromotion =strval($superieurYearCurrentPromotion)."-".strval($nextSuperieurYear);

        // Je vérifie si la promotion suivante à été enregistré sinon je la créer

        return  Promotion::firstOrCreate(
            ['name' => $nextPromotion ]

        );

    }

    public static function matiereWithTeacher(){

        return MatiereTeacher::all();
    }

}
