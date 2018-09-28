<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestCompany extends Model
{
    protected $table = "requests_companies";
    protected $fillable = ["client_id", "provider_id", "date_request", "status_request", "cost_amount", "payment_type_id", "is_paint"];
}
