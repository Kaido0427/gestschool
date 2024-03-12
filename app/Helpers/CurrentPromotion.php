<?php

namespace App\Helpers;

use App\Models\MatiereTeacher;
use App\Models\Promotion;
use Carbon\Carbon;

class CurrentPromotion
{
    public static function currentPromotion()
    {
        return Promotion::where('status', 'In_progress')->first();
    }

    public static function matiereWithTeacher(){

        return MatiereTeacher::all();
    }

}
