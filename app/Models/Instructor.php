<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $fillable = [
        'user_id',
        'area_of_expertise',
        'qualification',
        'short_bio',
    ];

    // Relationship to the User model
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
