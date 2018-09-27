<?php

namespace App\Http\Controllers\Admin;

use App\CarCompanyController;
use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public  function add_company(Request $request) {
//        dd($request->all());
        $rules = [
            'ruc_number' => 'required|min:11',
            'r_social' => 'required',
            'departamento' => 'required',
            'provincia' => 'required',
            'distrito' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'anio' => "required",
            'type' => "required",
            'color' => "required",
            'seat_capacity' => "required",
            'placa' => "required"
        ];
        $messages = [
            'type.required' => "El tipo es requerido",
            'color.required' => "El color  es requerido",
            'anio.required' => "El año es  requerido",
            'seat_capacity.required' => "La capacidad del vehículo es requerida",
            'placa.required' => "La placa es requerida",
            'first_name.required' => "El nombre es requerido",
            'last_name.required' => "El apellido es requerido",
            'email.required' => "El correo es requerido",
            'r_social.required' => 'El RUC es requerido',
            'phone.required' => 'El número de teléfono es requerido'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if( $validator -> fails()) {
            return back()->withErrors($validator)->withInput();
        }else {
            $approval_status = 0;
            if( $request->input('approval_status') == "on") {
                $approval_status = 1;
            }
            $company =  new Company;
            $rc =  $request->input('ruc_number');
            $company->ruc = $rc;
            $company->r_social = $request->input('r_social');
            $company->departamento = $request->input('departamento');
            $company->provincia = $request->input('provincia');
            $company->distrito = $request->input('distrito');
            $company->address = $request->input('direccion');
            $company->first_name = $request->input('first_name');
            $company->last_name = $request->input('last_name');
            $company->phone = $request->input('phone');
            $company->email = $request->input('email');
            $company->status = $approval_status;
            $company->save();

            $idCompany = $company->id;
            $carC = new CarCompanyController;
            $carC->placa = $request->input('placa');
            $carC->color = $request->input('color');
            $carC->type = $request->input('type');
            $carC->modelo = $request->input('modelo');
            $carC->anio = $request->input('anio');
            $carC->placa = $request->input('placa');
            $carC->id_emp = $idCompany;
            $carC->seat_capacity = $request->input('seat_capacity');
            $carC->save();


            return back();
//            dd($request->input('ruc_number'));
        }

    }
    public  function delete_cars_company($id) {
        $car =  CarCompanyController::find($id);
        $car->delete();
        return back();
    }
    public  function show_car_company(Request $request) {
        if($request->ajax()) {
//            return $request->input('idCo');
            $car = CarCompanyController::find($request->input('idCo'));
            return response()->json($car);
        }
    }
    public  function add_car_company(Request $request) {
        $rules = [
            'anio' => "required",
            'type' => "required",
            'color' => "required",
            'seat_capacity' => "required",
            'placa' => "required"
        ];
        $messages = [
            'type.required' => "El tipo es requerido",
            'color.required' => "El color  es requerido",
            'anio.required' => "El año es  requerido",
            'seat_capacity.required' => "La capacidad del vehículo es requerida",
            'placa.required' => "La placa es requerida",
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if( $validator -> fails()) {
            return back()->withErrors($validator)->withInput();
        }else {
            $carC =  new CarCompanyController;
            $carC->placa = $request->input('placa');
            $carC->type = $request->input('type');
            $carC->id_emp = $request->input('idCompany');
            $carC->placa = $request->input('placa');
            $carC->modelo = $request->input('modelo');
            $carC->color = $request->input('color');
            $carC->anio = $request->input('anio');
            $carC->seat_capacity = $request->input('seat_capacity');
            $carC->visibility_status = 1;
            $carC->save();
            return back();
        }

    }
    public  function delete_company($id) {
        $company = CarCompanyController::find($id);
        $company->delete();
        return back();
    }
}
