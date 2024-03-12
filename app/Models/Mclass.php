<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Mclass extends Model
{
    use HasFactory;

    protected $table = 'mclasses';
    public $incrementing = true;

    protected $fillable = [
        "sector_id",
        "level_id",
        "name",
        "time_usage"
    ];



    public function students() {

        return $this->hasMany(StudentClasse::class, 'mclass_id');
    }
    
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function sector() 
    {
        return $this->belongsTo(Sector::class);
    }
    public function teachers()
    {
        return $this->belongsToMany(User::class);
        
    }

    public function Users(){
        return $this->hasMany(User::class);
    }
    
    public function matieres()
    {
        return $this->belongsToMany(Matiere::class, 'matiere_mclass', 'mclass_id', 'matiere_id');
    }

    public function classeMatiere()
    {

        return $this->hasOne(ClassMatiere::class, "mclass_id");
    }
}
