<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Provider;

class Cartype extends Model
{
    protected $fillable = ["type", "base_distance", "minimum_fare", "price_per_mile", "price_per_time", "seat_capacity"];
    public function provider(){
        return $this->hasMany(Provider::class);
    }
}
