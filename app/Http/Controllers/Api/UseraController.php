<?php

namespace App\Http\Controllers\Api;

use App\Clients;
use App\Company;
use App\CompanyUsers;
use App\Request;
use App\RequestCompany;
use Illuminate\Http\Request as Rq;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UseraController extends Controller
{
    public  function addUser(Rq $request) {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
//            'departamento' => 'required',
            'pwd_client' => 'required',
//            'provincia' => 'required',
            'address' => 'required',
            'distrito' => 'required',
        ];
        $messages = [
            'first_name.required' => 'nombre requerido',
            'last_name.required' => 'apellido requerido',
            'phone.required' => 'apellido requerido',
            'email.required' => 'apellido requerido',
            'pwd_client.required' => 'contraseña requerida',
//            'departamento.required' => 'apellido requerido',
//            'provincia.required' => 'apellido requerido',
            'address.required' => 'apellido requerido',
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
            $client->pwd_client = md5($request->input('pwd_client'));
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
    public  function addCompany(Rq $request) {

        $rucaconsultar = $request->input('ruc');
        $company = Company::where('ruc', $rucaconsultar )->get();
        if(count($company) > 0) {
            $response = [
                'success' => false,
                'error' => 'Número de RUC ya registrado'
            ];

        }else {
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

                if($leer_respuesta["success"] == false) {
//                    return Response::json($leer_respuesta);
                    $response = [
                       'status' => 500,
                       'message' => $leer_respuesta["error"]
                    ];
                }else {
                    $rules = [
                        'first_name' => 'required',
                        'last_name' => 'required',
                        'phone' => 'required',
                        'email' => 'required',
                        'pwd_company' => 'required'


                    ];
                    $messages = [
                        'first_name.required' => 'nombre requerido',
                        'last_name.required' => 'apellido requerido',
                        'phone.required' => 'apellido requerido',
                        'email.required' => 'apellido requerido',
                        'pwd_company.required' => 'La contraseña es requerida'
                    ];
                    $validator = Validator::make($request->all(), $rules, $messages);
                    if($validator->fails()) {
                        $response = [
                            'status' => 500,
                            'message' => $validator->messages()
                        ];

                    }else {
                        $ruc = $rucaconsultar;
                        $r_social = $leer_respuesta["nombre_o_razon_social"];
                        $address = $leer_respuesta["direccion_completa"];
//                        $departamento = $leer_respuesta["departamento"];
//                        $provincia = $leer_respuesta["provincia"];
                        $distrito = $leer_respuesta["distrito"];

                        $comp = new Company;
                        $comp->ruc = $ruc;
                        $comp->address = $address;
                        $comp->r_social = $r_social;
//                        $comp->departamento  = $departamento;
//                        $comp->provincia = $provincia;
                        $comp->distrito = $distrito;

                        $comp->first_name = $request->input('first_name');
                        $comp->last_name = $request->input('last_name');
                        $comp->phone = $request->input('phone');
                        $comp->email = $request->input('email');
                        $comp->status = 1;
                        $comp->pwd_company =md5($request->input('pwd_company'));
                        $comp->save();
                        $response = [
                            'status' => 201,
                            'message' => 'Empresa Creado',
                            'id_user' => $comp->id
                        ];
                    }
            }
        }
        return Response::json($response);

    }
    public function addRequestClient(Rq $request) {
        $rules = [
            'company_id' => 'required',
            'payment_type_id' => 'required',
            'start_address' => 'required',
            'end_address' => 'required',
            'date_arrive' => 'required',
        ];
        $messages = [
            'company_id.required' => 'Id de Cliente Requerido',
            'payment_type_id.required' => 'Tipo de Pago Requerido',
            'start_address.required' => 'Origen Requerido',
            'end_address.required' => 'Destino Requerido',
            'date_arrive.required' => 'Hora de embarque requerido',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $response = [
                'status' => 500,
                'message' => $validator->messages()
            ];

        }else {
            $new_date_arrive =date('Y-m-d\TH:i', strtotime($request->input('date_arrive')));
            $req= new Request;
            $req->client_id = $request->input('company_id');
            $req->payment_type_id = $request->input('payment_type_id');
            $req->start_address = $request->input('start_address');
            $req->end_address = $request->input('end_address');
            $req->date_arrive = $new_date_arrive;
            $req->id_type_car = $request->input('id_type_car');
            if($request->input("is_courier") == 1) {
                $req->is_courier = 1;
            }
            $req->save();
            $response = [
                'status' => 201,
                'id_request'  => $req->id
            ];
        }

        return Response::json($response);
    }
    public  function  addRequestCompany(Rq $request) {
        $rules = [
            'company_id' => 'required',
            'payment_type_id' => 'required',
            'start_address' => 'required',
            'end_address' => 'required',
            'date_arrive' => 'required',
        ];
        $messages = [
            'company_id.required' => 'Id de Cliente Requerido',
            'payment_type_id.required' => 'Tipo de Pago Requerido',
            'start_address.required' => 'Origen Requerido',
            'end_address.required' => 'Destino Requerido',
            'date_arrive.required' => 'Hora de embarque requerido',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $response = [
                'status' => 500,
                'message' => $validator->messages()
            ];

        }else {
            $new_date_arrive =date('Y-m-d\TH:i', strtotime($request->input('date_arrive')));
            $req= new RequestCompany;
            $req->company_id = $request->input('company_id');
            $req->payment_type_id = $request->input('payment_type_id');
            $req->start_address = $request->input('start_address');
            $req->end_address = $request->input('end_address');
            $req->date_arrive = $new_date_arrive;
            $req->id_type_car = $request->input('id_type_car');
            $req->client_id = $request->input('client_id');
            if($request->input("is_courier") == 1) {
                $req->is_courier = 1;
            }
            $req->save();
            $response = [
                'status' => 201,
                'id_request'  => $req->id
            ];
        }
        return Response::json($response);
    }

    public function add_clients_company_api(Rq $request) {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
//            'departamento' => 'required',
//            'pwd_client' => 'required',
//            'provincia' => 'required',
            'address' => 'required',
            'distrito' => 'required',
        ];
        $messages = [
            'first_name.required' => 'nombre requerido',
            'last_name.required' => 'apellido requerido',
            'phone.required' => 'apellido requerido',
            'email.required' => 'apellido requerido',
//            'pwd_client.required' => 'contraseña requerida',
//            'departamento.required' => 'apellido requerido',
//            'provincia.required' => 'apellido requerido',
            'address.required' => 'apellido requerido',
            'distrito.required' => 'apellido requerido',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
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
            $client->pwd_client = md5($request->input('phone'));
//            $client->departamento = $request->input('departamento');
//            $client->provincia = $request->input('provincia');
            $client->distrito = $request->input('distrito');
            $client->address = $request->input('address');
            if ($request->input('id_company')) {
                $client->id_company = $request->input('id_company');
            }
            $client->save();
            $userCompany  = new CompanyUsers;
            $userCompany->id_company = $request->input('id_company');
            $userCompany->id_user = $client->id;
            $userCompany->save();


          $response = [
              'status' => 201,
              'message' => 'Usuario Creado',
              'id_user' => $client->id,
              "id_user_c" => $userCompany->id
          ];
        }
        return Response::json($response);
    }
}
