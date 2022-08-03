<?php

namespace App\Models;
use Conner\Likeable\Likeable;
use willvincent\Rateable\Rateable;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
  use HasFactory, Likeable, Rateable;
  protected $fillable = [
        'name',
        'age',
        'type',
        'price',
        'start_date',
        'dailyprogram_id',
        'expiry_date',
        'start_trip',
        'end_trip',
        'rest',
        'total',
        'image',
        'reiteration',
        'coutinent',
        'name_team',  
        'about',
        'offer'
    ];

// public function user()
// {
//   return $this->belongsTo(User::class);
  
// }
// public function governorate()
// {
//   return $this->belongsTo( governorate::class);
// }

// public function governorate()
// {
//   return $this->hasMany(Governorate_Trip::class);
// }
// public function state()
// {
//   return $this->hasMany(State_Trip::class);
// }
// public function area()
// {
//   return $this->hasMany(Area_Trip::class);
// }
// public function activity()
// {
//   return $this->hasMany(Activity_Trip::class);
// }

public function activities(){
  return $this-> belongsToMany(Activity::class,'activity_trip');
}

public function users(){
  return $this-> belongsToMany(Users::class,'trip_user');
}
public function areas(){
  return $this-> belongsToMany(Area::class,'area_trip');
}
public function governements(){
  return $this-> belongsToMany(Governement ::class,'governement_trip');
}
public function states(){
  return $this-> belongsToMany(State::class,'state_trip');
}

public function dailyprograms(){
  return $this-> hasOne(Dailyprogram::class);
}
}