<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\semestreUe;

class Semestre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'level_name',
        'level_id'
    ];

    public function semestreue()
    {
        return $this->belongsTo(semestreUe::class,'ue_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

  
    public function ues()
    {
        return $this->belongsToMany(UE::class, 'semestre_ue', 'semestre_id', 'ue_id');
    }

    public function matieres()
    {
        return $this->belongsToMany(Matiere::class, 'matiere_semestre', 'semestre_id', 'matiere_id');
    }
}
