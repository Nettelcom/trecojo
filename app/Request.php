<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Owner;
use App\Provider;

class Request extends Model
{
    protected $table = "Requests";
    protected $fillable = ["client_id", "provider_id", "date_request", "status_request", "cost_amount", "payment_type_id", "is_paint", "cost_provider", "margin", "id_type_car", "is_courier"];
    public function clients() {
        $this->belongsTo(Clients::class, '');
    }
    public  function provider() {
        $this->belongsTo(Provider::class);
    }
}
