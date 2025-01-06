<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = ['capsule_id', 'type', 'file_path', 'text_content'];

    // Relation avec la capsule
    public function capsule()
    {
        return $this->belongsTo(Capsule::class);
    }
    public static function isValidFileType($type)
    {
        $validTypes = ['text', 'image', 'video', 'audio'];
        return in_array($type, $validTypes);
    }
    public function reactions()
{
    return $this->morphMany(Reaction::class, 'reactable');
}
}