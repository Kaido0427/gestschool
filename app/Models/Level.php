<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code'
    ];
    public function sectors()
    {
        return $this->belongsToMany('App\Sector');
    }
    public function classes()
    {
        return $this->hasMany(Mclass::class);
        
    }

    public function semestres()
    {
        return $this->hasMany(Semestre::class);
    }

}
