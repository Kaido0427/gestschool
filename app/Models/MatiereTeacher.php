<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatiereTeacher extends Model
{
    use HasFactory;

    protected $table="matiere_teachers";
    protected $fillable = [
        "promotion_id", "matiere_id", "user_id"
    ];

    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'matiere_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function classMatieres()
    {
        return $this->hasMany(ClassMatiere::class, 'matiere_id');
    }
}
