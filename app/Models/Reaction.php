<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'capsule_id',
        'type',
        'comment_text',
    ];

    /**
     * Les valeurs possibles pour le type de réaction.
     */
    const TYPES = [
        'like',
        'comment',
    ];

    // Relation : Une réaction appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation : Une réaction appartient à une capsule
    public function capsule()
    {
        return $this->belongsTo(Capsule::class);
    }
}
