<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TokenSetting extends Model
{
    protected $table = 'token_setting';

    protected $fillable = ['name', 'token'];

    protected $cast = ['name' => 'string', 'token' => 'string'];
}
