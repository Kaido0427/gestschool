<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClasse extends Model
{
    use HasFactory;

    protected $fillable = [
        "promotion_id","mclass_id","user_id"
    ];

    public function mclass()
    {
        return $this->belongsTo(Mclass::class, 'mclass_id');
    }


    public function student(){

        return $this->belongsTo(User::class, 'user_id');

    }

    public function promotion(){

        return $this->belongsTo(Promotion::class, 'promotion_id');

    }
}
