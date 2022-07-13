<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image1',
        'image2',
        'image3',
        'description',
        'country',
        'city'
];
public function trips(){
  return $this->belongsToMany(Trip::class,'area_trip');
}
}
