<?php

namespace App\Http\Controllers\Admin;

use App\Clients;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientsController extends Controller
{
    public function show_clients(){
        $clients = Clients::paginate(10);

        return view('clients', compact('clients'));
    }
    public  function add_clients(Request $request) {
//            Clients::created([])
        $client = new Clients;
        $client->create($request->all());
        return back();
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
}
