<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapsuleRecipient extends Model
{
    use HasFactory;

    protected $table = 'capsule_recipients'; // Table pivot entre capsules et utilisateurs
    protected $fillable = ["capsule_id","user_id"];


    // Relation avec la capsule
    public function capsule()
    {
        return $this->belongsTo(Capsule::class);
    }

    // Relation avec l'utilisateur destinataire
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}