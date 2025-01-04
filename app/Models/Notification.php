<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'message', 'is_read', 'related_capsule_id'];

    // Relation avec l'utilisateur recevant la notification
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec la capsule liée à la notification (si applicable)
    public function capsule()
    {
        return $this->belongsTo(Capsule::class, 'related_capsule_id');
    }
}