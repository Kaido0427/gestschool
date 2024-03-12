<?php

namespace App\Http\Controllers\statistique;

use App\Helpers\CurrentPromotion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Mclass;
use App\Models\Level;
use App\Models\Sector;
use App\Models\Matiere;
use App\Models\User;
use App\Models\ClassMatiere;
use Illuminate\Support\Facades\DB;

class statistiqueController extends Controller
{
    public function showStat()
    {
        $classes = Mclass::with(['students' => function($query){

            $query->where('promotion_id', CurrentPromotion::currentPromotion()->id) ;

        }])->get();
        
        return view('welcome', compact('classes'));
    }
}

