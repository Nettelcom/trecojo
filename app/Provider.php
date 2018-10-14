<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = ["first_name", "last_name", "email",  "contacts", "picture", "approval_status", "number_acount"];
    public function cartype(){
        return $this->hasMany(Cartype::class,'idprovider');
    }
}
