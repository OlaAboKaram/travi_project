<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'timing',
        'image'
];




    public function datedays(){
        return $this->belongsTo(Dateday::class);
    }

}
