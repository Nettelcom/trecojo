<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Owner;
use App\Provider;

class Request extends Model
{
    protected $table = "requests";
    protected $fillable = ["client_id", "provider_id", "date_request", "status_request",
                                       "cost_amount", "payment_type_id", "is_paint", "cost_provider",
                                       "margin", "id_type_car", "is_courier", "peaje", "parqueo", "tespera", "paradas", "pTotal", "obs"];
    public function clients() {
        $this->belongsTo(Clients::class, 'client_id');
    }
    public  function provider() {
        $this->belongsTo(Provider::class);
    }
}
