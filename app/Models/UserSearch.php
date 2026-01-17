<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSearch extends Model
{
    protected $fillable = ['user_id', 'keyword'];
}

