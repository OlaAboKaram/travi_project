<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = [
      'name',
      
    ];

 
public function users(){
  return $this->belongsToMany(User::class,'activity_user');
}
public function trips(){
  return $this->belongsToMany(Trip::class,'activity_trip');
}
}
