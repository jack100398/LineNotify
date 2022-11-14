<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDefaultToken extends Model
{
    protected $fillable = ['user_id', 'token_id'];
}
