<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function capsules()
    {
        return $this->hasMany(Capsule::class);
    }

    // Relation avec les réactions
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    // Relation avec les notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Relation avec les capsules reçues
    public function receivedCapsules()
    {
        return $this->belongsToMany(Capsule::class, 'capsule_recipients');
    }
}