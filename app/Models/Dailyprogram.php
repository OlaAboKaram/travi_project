<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
      
class Dailyprogram extends Model
{
    use HasFactory;
    protected $fillable =
     [
        'trip_id',

];

public function datedays(){
    return $this->hasMany(Dateday::class);
}
public function trips(){
    return $this->belongsTo(Trip::class);
}


}
