<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ["ruc", "fist_name", "last_name", "phone", "email", "status", "address","r_social", "departamento", "provincia", "distrito", "pwd_company"];
    protected $table = "company";
}
