<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dateday extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'day',
];

    public function events(){
        return $this->hasMany(Event::class);
    }
    public function Dailyprograms(){
        return $this->belongsTo(Dailyprogram::class);
    }
}
