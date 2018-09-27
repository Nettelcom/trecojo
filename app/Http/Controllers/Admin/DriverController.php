<?php

namespace App\Http\Controllers\Admin;

use App\Cartype;
use App\Company;
use App\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    public  function addDriver(Request $request) {
        // Vehicle
//        dump($request->all());
        $rules = [
//            'base_distance' => "required",

            'anio' => "required",
            'type' => "required",
            'color' => "required",
            'seat_capacity' => "required",
            'placa' => "required",
            'first_name' => "required",
            'last_name' => "required",
            'email' => "required",
            'contacts' => "required",
            'picture' => "required",
        ];
        $messages = [
//            'base_distance.required' => "La distancia es requerida",
            'type.required' => "El tipo es requerido",
            'color.required' => "El color  es requerido",
            'anio.required' => "El año es  requerido",
            'seat_capacity.required' => "La capacidad del vehículo es requerida",
            'placa.required' => "La placa es requerida",
            'first_name.required' => "El nombre es requerido",
            'last_name.required' => "El apellido es requerido",
            'email.required' => "El correo es requerido",
            'contacts.required' => "El número es requerido",
            'picture.required' => "La imagen es requerida",
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $approval_status = 0;
        if ( $request->input('approval_status') == "on") {
            $approval_status = 1;
        }

        // Driver
        $driver =  new Provider;
        $driver->first_name = $request->input('first_name');
        $driver->last_name = $request->input('last_name');
        $driver->email = $request->input('email');
        $driver->contacts = $request->input('contacts');
        $driver->picture = $request->file('picture')->store('public');
        $driver->approval_status = $approval_status;
        $driver->save();
        $driver_id = $driver->id;



        $visible = 1;
        $car = new Cartype;
        $car->type = $request->input('type');
//        $car->base_distance = $request->input('base_distance');
//        $car->marca = $request->input('marca');
        $car->modelo = $request->input('modelo');
        $car->color = $request->input('color');
        $car->anio = $request->input('anio');
        $car->seat_capacity = $request->input('seat_capacity');
        $car->placa = $request->input('placa');
        $car->visibility_status = $visible;
        $car->idprovider = $driver_id;
        $car->save();
        return back()->withSuccess('Se reguistró correctamente!');;
    }
    public function show_img(Request $request) {
        if( $request->ajax()) {
            $img = Provider::find($request->input('idDriver'));
            return response()->json($img->picture);
        }
    }
    public function show_provider(Request $request) {
        if($request->ajax()) {
            $idProvider = $request->input('idProvider');
            $provider = new Provider;
            $providerData = $provider::find($idProvider);
            $car =  $provider::find($idProvider)->cartype()->get();
            return response()->json([$providerData, $car]);
        }
    }

    public  function chage_status_provider($id) {
        $provider = Provider::find($id );
        if( $provider -> approval_status == 0) {
            $provider -> approval_status  = 1;
        }else {
            $provider -> approval_status  = 0;
        }
        $provider->save();
        return back();
    }
    public  function edit_driver(Request $request) {
        $approval_status = 0;
        if ( $request->input('approval_status') == "on") {
            $approval_status = 1;
        }
        $visible = 1;
        $driver =  Provider::find($request->input('idProvider'));
        $driver->first_name = $request->input('first_name');
        $driver->last_name = $request->input('last_name');
        $driver->email = $request->input('email');
//        $driver->vehicle_id = $request->input('placa');
        $driver->contacts = $request->input('contacts');
        if($request->file('picture') != "") {
            $driver->picture = $request->file('picture')->store('public');
        }
        $driver->approval_status = $approval_status;

        $driver->cartype()->update([
            'type' => $request->input('type'),
//            'base_distance' => $request->input('base_distance'),
//            'marca'=> $request->input('marca'),
            'modelo' => $request->input('modelo'),
            'color' => $request->input('color'),
            'anio' => $request->input('anio'),
            'seat_capacity' =>$request->input('seat_capacity'),
            'placa' => $request->input('placa'),
            'visibility_status' => $visible
        ]);
        $driver->save();
        return back()->withSuccess('Se actualizó correctamente!');
    }
    public  function delete_provider($id) {
        $provider = Provider::find($id);
        $provider->delete();
        return back()->withSuccess('Se eliminó correctamente!');
    }

    public function add_car_provider(Request $request) {
        $provider = Provider::find($request->input('idProviderEdit'));
        $visible = 1;
        $provider->cartype()->create([
            'type' => $request->input('type'),
//            'base_distance' => $request->input('base_distance'),
//            'marca'=> $request->input('marca'),
            'modelo' => $request->input('modelo'),
            'color' => $request->input('color'),
            'anio' => $request->input('anio'),
            'seat_capacity' =>$request->input('seat_capacity'),
            'placa' => $request->input('placa'),
            'visibility_status' => $visible,
            'idprovider' => $request->input('idProviderEdit')
        ]);
        return back()->withSuccess('Se registró correctamente correctamente!');
    }
    public function  ruc(Request $request) {
        $rucaconsultar = $request->input('ruc_value');
        $company = Company::where('ruc', $rucaconsultar )->get();
        if(count($company) > 0) {
            return  json_encode([
                'success' => false,
                'error' => 'Número de RUC ya registrado'
            ]);
//            $rucaconsultar = $request->input('ruc_value');

//            return json_encode();
        }
        $ruta = "https://ruc.com.pe/api/v1/ruc";
        $token = "a2445df4-5a39-43aa-8a94-000ab3ad2961-50252a7a-ad97-4548-ad3f-64ad495aa1b0";



        $data = array(
            "token"	=> $token,
            "ruc"   => $rucaconsultar
        );

        $data_json = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            )
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta  = curl_exec($ch);
        curl_close($ch);

        $leer_respuesta = json_decode($respuesta, true);
        if (isset($leer_respuesta['errors'])) {
            //Mostramos los errores si los hay
            echo $leer_respuesta['errors'];
        } else {
            //Mostramos la respuesta
            return  json_encode($leer_respuesta);
        }
    }
}
