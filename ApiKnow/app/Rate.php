<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = [
        'type','user_id','answer_id'
    ];
    public $timestamps = false;
}
