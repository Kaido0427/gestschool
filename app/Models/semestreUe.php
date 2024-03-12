<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class semestreUe extends Model
{
    use HasFactory;
    protected $table = 'semestre_ue';
    protected $fillable = [
        'semestre_id',
        'ue_id'
    ];

    public function semestre()
    {
        return $this->belongsTo(semestre::class);
    }

    public function ue()
    {
        return $this->belongsTo(ue::class);
    }
}
