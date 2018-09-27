<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Provider;

class Cartype extends Model
{
    protected $fillable = ["type",  "modelo", "anio","color", 'placa', "seat_capacity", "visibility_status", 'idprovider'];
//    public function provider(){
//        return $this->hasMany(Provider::class, 'id');
//    }
}
