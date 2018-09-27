<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarCompanyController extends Model
{
    protected $fillable = ["type",  "modelo", "anio","color", 'placa', "seat_capacity", "visibility_status", 'id_emp'];
    protected $table = "company_car";

}
