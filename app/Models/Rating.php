<?php

namespace willvincent\Rateable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Rating extends Model
{
    public $fillable = ['rating','comment'];

    public function rateable()
    {
        return $this->morphTo();
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}