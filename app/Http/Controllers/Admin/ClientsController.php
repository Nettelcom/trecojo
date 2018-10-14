<?php

namespace App\Http\Controllers\Admin;

use App\Clients;
use App\Company;
use App\CompanyUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClientsController extends Controller
{
    public function show_clients(){
        $clients = Clients::paginate(10);

        return view('clients', compact('clients'));
    }
    public  function add_clients(Request $request) {
//            Clients::created([])
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
//            'pwd_client' => 'required|same:confirm_pwd',
//            'departamento' => 'required',
//            'provincia' => 'required',
            'distrito' => 'required',
            'address' => 'required',
        ];

        $messages = [
            'first_name.required' => 'El Nombre es requerido',
            'last_name.required' => 'El Apellido es requerido',
            'phone.required' => 'El Teléfono es requerido',
            'email.required' => 'El Email es requerido',
//            'pwd_client.required' => 'La Contraseña es requerido',
//            'pwd_client.same' => 'Las contraseñas no coinciden',
//            'departamento.required' => 'El Departamento es requerido',
//            'provincia.required' => 'El Provincia es requerido',
            'distrito.required' => 'El Disitrito es requerido',
            'address.required' => 'La Direción es requerida',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if( $validator->fails() ) {
            return back()->withErrors($validator)->withInput();
        }else {

//            $encrypt_pwd = md5($request->input('pwd_client'));
            $client = new Clients;
            $client->first_name = $request->input('first_name');
            $client->last_name = $request->input('last_name');
            $client->phone = $request->input('phone');
            $client->email = $request->input('email');
//            $client->pwd_client = $encrypt_pwd ;
            $client->pwd_client = md5($request->input('phone')) ;
//            $client->departamento = $request->input('departamento');
//            $client->provincia = $request->input('provincia');
            $client->distrito = $request->input('distrito');
            $client->address = $request->input('address');
            if($request->input('id_company')) {
                $client->id_company = $request->input('id_company');
            }
            $client->save();
            return back();
        }

    }
    public  function delete_client($id) {
        $client =  Clients::find($id);
        $client->delete();
        return back();
    }
    public  function get_information_client(Request $request) {
        if($request->ajax()) {
            $client = Clients::find($request->input('idClient'));
            return response()->json($client);
        }

    }
    public  function update_client(Request $request) {
        $client = Clients::find($request->input("idClient"));
        $client->update($request->all());
        return back();
    }
    public  function update_client_pwd(Request $request) {
        $rules = [
            'pwd_client' => 'required',
            'new_pwd' => 'required|same:pwd_confirm'
        ];

        $messages = [
            'pwd_client.required' => 'La contraseña es requerida',
            'new_pwd.required' => 'La nueva contraseña es requerida',
            'new_pwd.same' => 'Las contraseñas no coinciden'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $client =  Clients::find($request->input('idClient'));
        if($client->pwd_client == md5($request->input('pwd_client'))) {
            $client->pwd_client = md5($request->input('new_pwd'));
            $client->save();
            return back()->withSuccess('Se actualizó la contraseña correctamente!');;
        }else {
            return back()->withErrors([
                'message' => 'La contraseña es incorrecta'
            ]);
        }
    }


    public function add_clients_company(Request $request) {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
//            'pwd_client' => 'required|same:confirm_pwd',
//            'departamento' => 'required',
//            'provincia' => 'required',
            'distrito' => 'required',
            'address' => 'required',
        ];

        $messages = [
            'first_name.required' => 'El Nombre es requerido',
            'last_name.required' => 'El Apellido es requerido',
            'phone.required' => 'El Teléfono es requerido',
            'email.required' => 'El Email es requerido',
//            'pwd_client.required' => 'La Contraseña es requerido',
//            'pwd_client.same' => 'Las contraseñas no coinciden',
//            'departamento.required' => 'El Departamento es requerido',
//            'provincia.required' => 'El Provincia es requerido',
            'distrito.required' => 'El Disitrito es requerido',
            'address.required' => 'La Direción es requerida',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if( $validator->fails() ) {
            return back()->withErrors($validator)->withInput();
        }else {

//            $encrypt_pwd = md5($request->input('pwd_client'));
            $client = new Clients;
            $client->first_name = $request->input('first_name');
            $client->last_name = $request->input('last_name');
            $client->phone = $request->input('phone');
            $client->email = $request->input('email');
//            $client->pwd_client = $encrypt_pwd ;
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


            return back();
        }
    }
    public function get_company_user(Request $request) {
        if  ($request->ajax()) {
            $id =  $request->input('idClient');
            $companies = Company::all();
            $cp = DB::select("SELECT * FROM company t1 WHERE  NOT EXISTS (SELECT NULL FROM  company_users t2
                    WHERE t2.id_company = t1.id and id_user = $id) ");
            $userC = CompanyUsers::where("id_user", $request->input('idClient'))->get();
            $company_user = [];
            $is_empresa = "";
            $no_empresa = "";


            if (count($userC) > 0) {
                foreach ($companies as $company) {
                    foreach ($userC as $us) {
                        if ($us->id_company == $company->id) {
                            $company_user[] = [
                                "id" => $us->id,
                                "company" => $company->r_social,
                                "id_company" => $company->id
                            ];
                            $is_empresa .= "<tr>";
                            $is_empresa .= "<td width='400px'>{$company->r_social}</td>";
                            $is_empresa .= "<td><a href='deleteUserCompany/{$us->id}' class='btn btn-danger'><i class='fa fa-trash'></i></a></td>";
                            $is_empresa .= "</td>";
                            $is_empresa .= "</tr>";

                        } else {
                            $company_user [] = [
                                "company_no" => $company->r_social,
                                "id_company_no" => $company->id
                            ];

                        }

                    }
                }

            }
            foreach ($cp as $c) {
                    $no_empresa .= "<tr>";
                    $no_empresa .= "<td width='400px'>{$c->r_social}</td>";
                    $no_empresa .= '<td>';
                    $no_empresa .= "<a  href='addUserCompany/{$c->id}/{$request->input('idClient')}' class='btn btn-success' value=''><i class='fa fa-trash'></i></a>";
                    $no_empresa .= "</td>";
                    $no_empresa .= "</tr>";
            }
            return response()->json([
                'is_empresa' => $is_empresa,
                'no_empresa' => $no_empresa
            ]);
        }
     }
    public function addUserCompany($idC, $idU) {
        $cUser = new CompanyUsers;
        $cUser->id_company = $idC;
        $cUser->id_user =  $idU;
        $cUser->save();
        return back();
    }
    public  function deleteUserCompany($id) {
        $cUser =  CompanyUsers::find($id);
        $cUser->delete();
        return back();
    }
}
