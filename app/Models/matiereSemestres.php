<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class matiereSemestres extends Model
{
    use HasFactory;
    protected $table = "matiere_semestre";
    protected $fillable = [
        'matiere_id',
        'semestre_id'
    ];

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }
}
