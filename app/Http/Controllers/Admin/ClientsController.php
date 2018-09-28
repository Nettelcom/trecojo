<?php

namespace App\Http\Controllers\Admin;

use App\Clients;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            'pwd_client' => 'required|same:confirm_pwd',
            'departamento' => 'required',
            'provincia' => 'required',
            'distrito' => 'required',
            'address' => 'required',
        ];
        $messages = [
            'first_name.required' => 'El Nombre es requerido',
            'last_name.required' => 'El Apellido es requerido',
            'phone.required' => 'El Teléfono es requerido',
            'email.required' => 'El Email es requerido',
            'pwd_client.required' => 'La Contraseña es requerido',
            'pwd_client.same' => 'Las contraseñas no coinciden',
            'departamento.required' => 'El Departamento es requerido',
            'provincia.required' => 'El Provincia es requerido',
            'distrito.required' => 'El Disitrito es requerido',
            'address.required' => 'La Direción es requerida',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if( $validator->fails() ) {
            return back()->withErrors($validator)->withInput();
        }else {
            $encrypt_pwd = md5($request->input('pwd_client'));
            $client = new Clients;
            $client->first_name = $request->input('first_name');
            $client->last_name = $request->input('last_name');
            $client->phone = $request->input('phone');
            $client->email = $request->input('email');
            $client->pwd_client = $encrypt_pwd ;
            $client->departamento = $request->input('departamento');
            $client->provincia = $request->input('provincia');
            $client->distrito = $request->input('distrito');
            $client->address = $request->input('address');
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
}
