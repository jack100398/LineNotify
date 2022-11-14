<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class publishNotifyLog extends Model
{
    protected $fillable = ['name', 'message', 'chat_name'];

    protected $cast = ['name' => 'string', 'message' => 'string', 'chat_name' => 'string'];
}
