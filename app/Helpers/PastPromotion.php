<?php

namespace App\Helpers;

use App\Models\MatiereTeacher;
use App\Models\Promotion;
use Carbon\Carbon;

class PastPromotion
{
    public static function pastPromotion()
    {
        // je récupere le nom de la promotion actuel
        
        $currentPromotion = Promotion::where('status', 'In_progress')->first();

        $currentPromotionName = $currentPromotion["name"];

        // je split le name et je récupere l'année superieur
        $inferieurYearCurrentPromotion = intval(explode("-", $currentPromotionName)[0]) -1;

        $pastSuperieurYear = intval($inferieurYearCurrentPromotion) + 1;
    
        $pastPromotion =strval($inferieurYearCurrentPromotion)."-".strval($pastSuperieurYear);

        return  Promotion::firstOrCreate(
            ['name' => $pastPromotion ]
        );

    }

    public static function matiereWithTeacher(){

        return MatiereTeacher::all();
    }

}
