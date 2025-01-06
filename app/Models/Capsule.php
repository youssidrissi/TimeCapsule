<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;


class Capsule extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id', 'is_public', 'status', 'open_date'];

    protected $casts = [
        'is_public' => 'boolean',
        'open_date' => 'datetime',
    ];
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
    // Accesseur pour le champ "status"
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    // Scope pour filtrer les capsules privées
    public function scopePrivate($query)
    {
        return $query->where('is_public', false);
    }

    // Scope pour filtrer par type de capsule
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Attribut calculé : Est-ce que la capsule est prête à ouvrir ?
    public function getIsReadyToOpenAttribute()
    {
        return $this->open_date <= now();
    }

    // Boot : Action automatique lors de la création d'une capsule
    protected static function booted()
    {
        static::created(function ($capsule) {
            // Exemple : Notification ou log
            Log::info("Nouvelle capsule créée : " . $capsule->title);
        });
    }
}