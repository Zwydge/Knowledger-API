<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reputation extends Model
{
    protected $fillable = [
        'value','user_id','category_id'
    ];
    public $timestamps = false;
}
