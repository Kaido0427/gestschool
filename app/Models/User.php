<?php

namespace App\Models;

use App\Helpers\CurrentPromotion;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        "firstname",
        'address',
        'email',
        'phone',
        "gender",
        'password',
        'type',
        "matricule",
        'is_active',
        'birth_place',
        'birth_day',
        'nationality',
        'night'

    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role_id' => 'array'

    ];

    // un etudiant est associé à une classe

    public function studentCurrentClasse()
    {

        return $this->studentPromotionClasses()->where('promotion_id', CurrentPromotion::currentPromotion()->id)->first();
    }

    public function avatar()
    {
        return $this->hasOne(Avatar::class);
    }
    // un professeur enseigne des matières dans plusieurs classes


    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    // cette méthode renvoies la listes des classes d'un professeur  
    public function classes()
    {
        return $this->belongsToMany(ClassMatiere::class, "user_id");
    }

    public function matiere()
    {

        return $this->belongsTo(Matiere::class);
    }
    public function roles()
    {

        return $this->belongsToMany(Role::class);
    }

    public function getRoleIds()
    {
        $roleIds = [];
        $roles = $this->roles()->get();
        if (count($roles)) {

            foreach ($roles as $role) {

                array_push($roleIds, $role['pivot']['role_id']);
            }
        }
        return $roleIds;
    }
    public function notes()
    {
        return $this->hasMany(Note::class, "user_id");
    }

    public function evaluation()
    {
        return $this->hasMany(Evaluate::class, "user_id");
    }


    public function studentPromotionClasses()
    {
        return $this->hasMany(StudentClasse::class, "user_id");
    }


    public function Mclass()
    {
        return $this->belongsTo(Mclass::class, '');
    }

    public function teacher()
    {
        return $this->hasOne(MatiereTeacher::class, 'user_id');
    }
}
