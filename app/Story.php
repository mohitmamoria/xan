<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = ['name'];

    protected $dates = ['deactivated_at'];
}
