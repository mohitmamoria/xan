<?php

namespace App;

use App\Chapter;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = ['name'];

    protected $dates = ['deactivated_at'];

    public function chapters()
    {
    	return $this->hasMany(Chapter::class);
    }
}
