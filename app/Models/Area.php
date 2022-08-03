<?php

namespace App\Models;
use Conner\Likeable\Likeable;
use willvincent\Rateable\Rateable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory,Likeable, Rateable;

    protected $fillable = [
        'name',
        'image1',
        'image2',
        'image3',
        'description',
        'country',
        'city',
        'latitude',
        'longitude',
];
public function trips(){
  return $this->belongsToMany(Trip::class,'area_trip');
}
public function comments(){
  return $this->hasMany(Comment::class);
}
}
