<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = ["first_name", "last_name", "email","cartype_id", "placa",  "contacts", "picture", "approval_status"];
    public function cartype(){
        return $this->belongsTo(Cartype::class);
    }
}
