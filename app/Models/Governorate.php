<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    use HasFactory;
    protected $fillable = [
      'name',];
// public function trip()
// {
//   return $this->hasMany(trip::class);

// }
public function trips(){
  return $this->belongsToMany(Trip::class,'governement_trip');
}
}