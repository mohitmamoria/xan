<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = ['story_id', 'sequence', 'body'];

    public $timestamps = false;
    
    protected $dates = ['deactivated_at'];
}
