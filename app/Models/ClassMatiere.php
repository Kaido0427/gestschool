<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassMatiere extends Model
{
    use HasFactory;
    protected $table = 'matiere_mclass';

    protected $fillable = [
        'syllabus',
        'mclass_id',
        'matiere_id',
        'user_id',
        'credit_number',
        'max_note',
        'promotion_id',
        'sector_id', // Ajout du champ sector_id
        'level_id', // Ajout du champ level_id
    ];


    // Dans votre modèle ClassMatiere
    public function matiereTeacher()
    {
        return $this->hasOne(MatiereTeacher::class, 'matiere_id');
    }

    // Ajout de la relation teachers()
    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    // Dans votre modèle ClassMatiere
    public function teacherIds()
    {
        return $this->teachers()->pluck('id')->toArray(); // Modification pour récupérer les IDs directement
    }

    // Correction de la relation matiere()
    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'matiere_id');
    }

    // Correction de la relation classe()
    public function classe()
    {
        return $this->belongsTo(Mclass::class, "mclass_id");
    }
 
    // Correction de la relation matiereTeachers()
    public function matiereTeachers()
    {
        return $this->hasMany(MatiereTeacher::class, 'matiere_id');
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    // Correction de la relation level()
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    // Dans votre modèle ClassMatiere
    public function semestres()
    {
        return $this->belongsToMany(Semestre::class, 'matiere_semestre', 'matiere_id', 'semestre_id');
    }

    // Dans votre modèle ClassMatiere
    public function teachersThroughMatiereTeacher()
    {
        return $this->hasManyThrough(
            User::class, // Modèle cible
            MatiereTeacher::class, // Modèle intermédiaire
            'matiere_id', // Clé étrangère de la classe matière dans la table matiere_teacher
            'id', // Clé primaire de la matière dans la table classMatiere
            'matiere_id', // Clé primaire de la matière dans la table matiere
            'user_id' // Clé étrangère de l'utilisateur dans la table matiere_teacher
        );
    }
}
