<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluate extends Model
{
    use HasFactory;

    protected $fillable = [
        "matiere_id",
        "user_id",
        "controle",
        "examen",
        "promotion_id"
    ];


    public function student(){
        return $this->belongsTo(User::class, 'user_id' );
    }

    public function matiere(){
        return $this->belongsTo(Matiere::class, 'matiere_id' );
    }
}
