<?php

namespace App\Http\Controllers\Api;

use App\Clients;
use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UseraController extends Controller
{
    public  function addUser(Request $request) {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'departamento' => 'required',
            'provincia' => 'required',
            'distrito' => 'required',
        ];
        $messages = [
            'first_name.required' => 'nombre requerido',
            'last_name.required' => 'apellido requerido',
            'phone.required' => 'apellido requerido',
            'email.required' => 'apellido requerido',
            'departamento.required' => 'apellido requerido',
            'provincia.required' => 'apellido requerido',
            'distrito.required' => 'apellido requerido',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            $response = [
                'status' => 500,
                'message' => $validator->messages()
            ];
        }else {
            $client = new Clients;
            $client->first_name = $request->input('first_name');
            $client->last_name = $request->input('last_name');
            $client->phone = $request->input('phone');
            $client->email = $request->input('email');
            $client->address = $request->input('address');
            $client->provincia = $request->input('provincia');
            $client->distrito = $request->input('distrito');
            $client->departamento = $request->input('departamento');
            $client->save();
            $response = [
                'status' => 201,
                'message' => 'Usuario Creado',
                'id_user' => $client->id
            ];
        }

        return Response::json($response);
    }
    public  function addCompany(Request $request) {
        $rucaconsultar = $request->input('ruc');
        $company = Company::where('ruc', $rucaconsultar )->get();
        if(count($company) > 0) {
            return  json_encode([
                'success' => false,
                'error' => 'Número de RUC ya registrado'
            ]);

        }
        $ruta = "https://ruc.com.pe/api/v1/ruc";
        $token = "b87adb2f-077f-453c-ab65-cac2f890b38b-09adc56f-c183-4f5c-ade0-13776f5b0562";



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
        if(isset($leer_respuesta["errors"])) {
            return Response::json($leer_respuesta);
        }else {
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'email' => 'required',
            ];
            $messages = [
                'first_name.required' => 'nombre requerido',
                'last_name.required' => 'apellido requerido',
                'phone.required' => 'apellido requerido',
                'email.required' => 'apellido requerido'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails()) {
                $response = [
                  'status' => 500,
                  'message' => $validator->messages()
                ];

            }else {
                $ruc = $leer_respuesta["ruc"];
                $r_social = $leer_respuesta["nombre_o_razon_social"];
                $address = $leer_respuesta["direccion_completa"];
                $departamento = $leer_respuesta["departamento"];
                $provincia = $leer_respuesta["provincia"];
                $distrito = $leer_respuesta["distrito"];

                $comp = new Company;
                $comp->ruc = $ruc;
                $comp->address = $address;
                $comp->r_social = $r_social;
                $comp->departamento  = $departamento;
                $comp->provincia = $provincia;
                $comp->distrito = $distrito;

                $comp->first_name = $request->input('first_name');
                $comp->last_name = $request->input('last_name');
                $comp->phone = $request->input('phone');
                $comp->email = $request->input('email');
                $comp->status = 1;
                $comp->save();
                $response = [
                    'status' => 201,
                    'message' => 'Empresa Creado',
                    'id_user' => $comp->id
                ];
            }
            return Response::json($response);


        }
//        if (isset($leer_respuesta['errors'])) {
//            //Mostramos los errores si los hay
//            echo $leer_respuesta['errors'];
//        } else {
//            //Mostramos la respuesta
//            return  json_encode($leer_respuesta);
//        }

    }
}
