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
        "promotion_id",
        "cours_id"
    ];


    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'matiere_id');
    }

    public function matiereTeacher()
    {
        return $this->hasOneThrough(
            MatiereTeacher::class,
            Matiere::class,
            'id', // Foreign key on the Matiere model
            'matiere_id', // Foreign key on the MatiereTeacher model
            'matiere_id', // Local key on the Evaluate model
            'id' // Local key on the Matiere model
        );
    }
}
