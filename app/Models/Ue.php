<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ue extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'code'];

    public function semestres()
    {
        return $this->belongsToMany(Semestre::class, 'semestre_ue', 'ue_id', 'semestre_id');
    }

    public function matieres()
    {
        return $this->hasMany(Matiere::class, 'ue_id');
    }
}
