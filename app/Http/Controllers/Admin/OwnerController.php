<?php

namespace App\Http\Controllers\Admin;

use App\Owner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OwnerController extends Controller
{
    public  function show_update_user(Request $request) {
        if($request->ajax()) {
            $user = Owner::find($request->input('idUser'));
            return response()->json($user);
        }
    }
    public  function user_update(Request $request) {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'contacts' => 'required',
        ];
        $messages = [
            'first_name.required' => 'El nombre es requerido',
            'last_name.required' => 'El apellido es requerido',
            'email.required' => 'El email es requerido',
            'contacts.required' => 'El teléfono es requerido',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }else {
            $user = Owner::find( $request->input('idUser') );
            $user->update($request->all());
            return back();
        }

    }

    public  function delete_user($id) {
        $user = Owner::find($id);
        $user->delete();
        return back();
    }

    public  function add_user(Request $request) {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'contacts' => 'required',
        ];
        $messages = [
            'first_name.required' => 'El nombre es requerido',
            'last_name.required' => 'El apellido es requerido',
            'email.required' => 'El email es requerido',
            'contacts.required' => 'El teléfono es requerido',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }else {
            $user = new Owner;
            $user->create($request->all());
            return back();
        }
    }
}
