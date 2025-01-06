<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable 
{
    use HasFactory,HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    

    // Relation avec les capsules créées par l'utilisateur
    public function capsules()
    {
        return $this->hasMany(Capsule::class);
    }

    // Relation avec les réactions effectuées par l'utilisateur
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    // Relation avec les notifications reçues par l'utilisateur
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Relation avec les capsules reçues par l'utilisateur
    public function receivedCapsules()
    {
        return $this->belongsToMany(Capsule::class, 'capsule_recipients');
    }
}
