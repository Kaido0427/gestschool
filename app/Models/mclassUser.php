<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mclassUser extends Model
{
    use HasFactory;

    protected $table = 'mclass_user';

    protected $fillable = [
        'mclass_id',
        'user_id',
        'matiere_id',
        'status',
    ];

    public function teacher(){
        return $this->belongsTo(User::class);
    }
}
