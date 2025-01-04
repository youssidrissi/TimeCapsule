<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    // Champs modifiables (facultatif, à configurer selon tes besoins)
    protected $fillable = ['name', 'email', 'password', 'profile_picture'];

    // Un utilisateur peut avoir plusieurs capsules
    public function capsules()
    {
        return $this->hasMany(Capsule::class);
    }

    // Un utilisateur peut avoir plusieurs réactions
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    // Un utilisateur peut recevoir plusieurs notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Un utilisateur peut être destinataire de plusieurs capsules
    public function capsuleRecipients()
    {
        return $this->hasMany(CapsuleRecipient::class);
    }
}
