<img src="{{  $message->embed(storage_path("app/logo-trecojo.jpg"))  }}" width="100px" height="100px" alt="">

<h3>Estimad@ {{ $client["first_name"] }}  {{ $client["last_name"] }} :</h3>
<span>Hemos recibido su solicitud de servicio es: </span><br>
<span><strong>Inicio: </strong>{{ $request["inicio"] }}</span><br>
<span><strong>Fin: </strong>{{ $request["fin"] }}</span><br>
<span><strong>El Costo es de: </strong>S/.{{ $request["cost_amount"] }}</span><br>
<span>Por favor, ingrese a la pagina  <a href="http://trecojo.pe/">http://trecojo.pe/</a> e inicie sesión y apruebe el costo de servicio. Por favor, no responda este mensaje.</span>
