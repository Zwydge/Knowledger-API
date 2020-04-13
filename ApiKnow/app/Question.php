<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'content','user_id','category_id'
    ];
    public $timestamps = false;
}
