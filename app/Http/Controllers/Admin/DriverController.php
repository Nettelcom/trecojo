<?php

namespace App\Http\Controllers\Admin;

use App\Cartype;
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
            'base_distance' => "required",
            'minimum_fare' => "required",
            'price_per_mile' => "required",
            'price_per_time' => "required",
            'seat_capacity' => "required",
            'placa' => "required",
            'first_name' => "required",
            'last_name' => "required",
            'email' => "required",
            'contacts' => "required",
            'picture' => "required",
        ];
        $messages = [
            'base_distance.required' => "La distancia es requerida",
            'minimum_fare.required' => "El precio es requerido",
            'price_per_mile.required' => "El precio por milla  es requerido",
            'price_per_time.required' => "El precio por tiempo es  requerido",
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
        $visible = 1;
        $car = new Cartype;
        $car->type = $request->input('type');
        $car->base_distance = $request->input('base_distance');
        $car->minimum_fare = $request->input('minimum_fare');
        $car->price_per_mile = $request->input('price_per_mile');
        $car->price_per_time = $request->input('price_per_time');
        $car->seat_capacity = $request->input('seat_capacity');
        $car->placa = $request->input('placa');
        $car->visibility_status = $visible;
        $car->save();
        $vehicle_id = $car->id;
        // Driver
        $driver =  new Provider;
        $driver->first_name = $request->input('first_name');
        $driver->last_name = $request->input('last_name');
        $driver->email = $request->input('email');
        $driver->cartype_id = $vehicle_id;
        $driver->vehicle_id = $request->input('placa');
        $driver->contacts = $request->input('contacts');
        $driver->picture = $request->file('picture')->store('public');
        $driver->approval_status = $approval_status;
        $driver->save();
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
            $car = $provider::find($idProvider)->cartype()->get();
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
        $driver->vehicle_id = $request->input('placa');
        $driver->contacts = $request->input('contacts');
        if($request->file('picture') != "") {
            $driver->picture = $request->file('picture')->store('public');
        }
        $driver->approval_status = $approval_status;

        $driver->cartype()->update([
            'type' => $request->input('type'),
            'base_distance' => $request->input('base_distance'),
            'minimum_fare' => $request->input('minimum_fare'),
            'price_per_mile' => $request->input('price_per_mile'),
            'price_per_time' => $request->input('price_per_time'),
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
}
