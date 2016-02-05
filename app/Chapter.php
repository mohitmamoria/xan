<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = ['story_id', 'sequence', 'body'];

    protected $dates = ['deactivated_at'];
}
