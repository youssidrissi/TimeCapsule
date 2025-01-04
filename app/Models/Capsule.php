<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capsule extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id', 'is_public', 'status', 'open_date'];

    // Relation avec l'utilisateur créateur de la capsule
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec les contenus de la capsule
    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    // Relation avec les réactions sur la capsule
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    // Relation avec les destinataires de la capsule
    public function recipients()
    {
        return $this->belongsToMany(User::class, 'capsule_recipients');
    }
}
