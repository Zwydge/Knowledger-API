<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'content','user_id','question_id'
    ];
    public $timestamps = false;
}
