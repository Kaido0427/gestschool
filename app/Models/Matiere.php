<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'ue_id'
    ];
    public function semestres()
    {
        return $this->hasManyThrough(
            Semestre::class,
            matiereSemestres::class,
            'matiere_id', // Clé étrangère de matiere_semestre
            'id', // Clé primaire de semestre
            'id', // Clé primaire de matiere
            'semestre_id' // Clé étrangère de semestre
        );
    }
    public function classe()
    {
        return $this->hasOne(ClassMatiere::class, 'matiere_id');
    }

    public function teacher()
    {
        return $this->hasOne(ClassMatiere::class, 'user_id');
    }

    public function classes()
    {
        return $this->belongsToMany(Mclass::class);
    }

    public function ue()
    {
        return $this->belongsTo(Ue::class, 'ue_id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class, "matiere_id");
    }

    public function evaluation()
    {
        return $this->hasMany(Evaluate::class, "matiere_id");
    }

    public function classMatieres()
    {
        return $this->hasMany(ClassMatiere::class, "matiere_id");
    }

    public function matiereTeachers()
    {

        return $this->hasMany(MatiereTeacher::class, 'user_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class);
    }
}
