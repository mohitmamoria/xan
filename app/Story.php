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

    public static function random()
    {
    	return static::active()->orderByRaw('RAND()')->first();
    }

    public function scopeActive($query)
    {
    	return $query->whereNull('deactivated_at');
    }
}
