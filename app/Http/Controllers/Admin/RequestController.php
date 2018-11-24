<?php

namespace App\Http\Controllers\Admin;

use App\Clients;
use App\Company;
use App\Request;
use App\RequestCompany;
use Illuminate\Http\Request as Rq;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RequestController extends Controller
{
    public  function update_data_request(Rq $request) {
        $req = Request::find($request->input('idRequest'));

        $req->update($request->all());
//
        if($request->input("send_mail") == 1) {
            $id_user = $req->client_id;
            $client = Clients::find($id_user);

//            Mail::send("email", ["client" =>$client,"request" => $request], function ( $message ) use ( $client) {
//                    $message->from("trecojo@prueba.com");
//                    $message->to($client->email);
//                    $message->subject("Prueba de Trecojo");
//            });
        }

        return back();
    }
    public  function change_state_request($id) {
        $req = Request::find($id);

        if($req->status_request == 0) {
            $status = 1;
        }else {
            $status = 0;
        }
        $req->status_request = $status;
        $req->save();
        return back();
    }
    public  function change_is_payment_request($id) {
        $req = Request::find($id);

        if($req->is_paint == 0) {
            $status = 1;
        }else {
            $status = 0;
        }
        $req->is_paint = $status;
        $req->save();
        return back();
    }
    public  function delete_request($id) {
        $req = Request::find($id);
        if($req->active == 0) {
            $status = 1;
        }else {
            $status = 0;
        }
        $req->active = $status;
        $req->save();
        return back();
    }
    public  function details_request(Rq $request) {
        if($request->ajax()) {
            $req = Request::find($request->input('idRequest'));
            $new_date_arrive = $req->date_arrive;
            $new_date_request = $req->date_request;
            $new_date_end = $req->date_end;


            if($req->date_request!= "") {
                $new_date_request = date('Y-m-d\TH:i', strtotime($req->date_request));

            }
            if($req->date_arrive != "") {
                $new_date_arrive = date('Y-m-d\TH:i', strtotime($req->date_arrive));
            }
            if($req->date_end != "") {
                $new_date_end = date('Y-m-d\TH:i', strtotime($req->date_end));

            }
            if($req->paradas == "") {
                $paradas = "vacio";
            }else {
                $paradas = $req->paradas;
            }
            $response = [
                'id' => $req->id,
                'payment_type_id' =>   $req->payment_type_id,
                'date_request' => $new_date_request,
                'date_arrive' =>  $new_date_arrive,
                'date_end' => $new_date_end,
                'peaje' => $req->peaje,
                'parqueo' => $req->parqueo,
                'tespera' => $req->tespera,
                "paradas" => $paradas,
                "obs" => $req->obs
            ];
            return response()->json([$response]);
        }
    }
    public  function update_detail_request(Rq $request) {

        $paradas = $request->input("paradas");
        $arrParadas = array();



        $req = Request::find($request->input('idRequest'));
//        $req->update($req->all());
        $new_date_request = date('Y-m-d\TH:i', strtotime($request->input('date_request')));
        $new_date_arrive = date('Y-m-d\TH:i', strtotime($request->input('date_arrive')));
        $new_date_end = date('Y-m-d H:i', strtotime($request->input('date_end')));
        $req->date_request = $new_date_request;
        $req->date_arrive = $new_date_arrive;
        $req->date_end = $new_date_end;
        $req->payment_type_id = $request->input('payment_type_id');
        $req->peaje = $request->input("peaje");
        $req->parqueo = $request->input("parqueo");
        $req->tespera = $request->input("tespera");
        $req->cost_provider = $req->cost_provider + $request->input("peaje") +  $request->input("parqueo") + $request->input("tespera");
        $pTotal = $req->cost_amount +  $request->input("peaje") +  $request->input("parqueo") + $request->input("tespera");
        $req->pTotal = $pTotal;
        $req->obs =  $request->input("obs");

        if($paradas[0] != "") {
            for($i = 0; $i < count($paradas); $i++) {
                $arrParadas[] = $paradas[$i];
            }
            $req->paradas = json_encode($arrParadas);
        }else {
            $req->paradas =null;
        }


        $req->save();
        return back();


    }

    public  function add_request_modal_company(Rq $request) {
//        return $request->all();
        $req= new RequestCompany;
        $new_date_arrive = date('Y-m-d\TH:i', strtotime($request->input('date_arrive')));
        $req->company_id = $request->input('client_id');
        $req->payment_type_id = $request->input('payment_type_id');
        $req->start_address = $request->input('start_address');
        $req->end_address = $request->input('end_address');
        $req->date_arrive = $new_date_arrive;
        $req->client_id =  $request->input('user_id');
        $req->provider_id =  $request->input('provider_id');
        $req->status_travel =  1;
        $req->id_type_car =  $request->input('id_type_car');
        if($request->is_courier == "on") {
            $req->is_courier = 1;
        }
        $req->save();
        return back();


    }


    public  function add_request_modal_client(Rq $request) {
        $req= new Request;
        $new_date_arrive = date('Y-m-d\TH:i', strtotime($request->input('date_arrive')));
        $req->client_id = $request->input('client_id');
        $req->payment_type_id = $request->input('payment_type_id');
        $req->start_address = $request->input('start_address');
        $req->end_address = $request->input('end_address');
        $req->date_arrive = $new_date_arrive;
        $req->provider_id =  $request->input('provider_id');
        $req->status_travel =  1;
        $req->id_type_car =  $request->input('id_type_car');
        if($request->is_courier == "on") {
            $req->is_courier = 1;
        }
        $req->save();
        return back();
    }





//    COMPANIES
    public  function update_data_company_request(Rq $request) {
        $req = RequestCompany::find($request->input('idRequestC'));
        $req->update($request->all());
        return back();
    }
    public  function change_state_request_company($id) {
        $req = RequestCompany::find($id);
        $status = 0;
        if($req->status_request == 0) {
            $status = 1;
        }
        $req->status_request = $status;
        $req->save();
        return back();
    }
    public  function change_is_payment_request_company($id) {
        $req = RequestCompany::find($id);
        $payment = 0;
        if($req->is_paint == 0) {
            $payment = 1;
        }
        $req->is_paint = $payment;
        $req->save();
        return back();
    }
    public  function delete_request_company($id) {
        $req = RequestCompany::find($id);
        $req->delete();
        return back();
    }
    public function get_request_company(Rq $request) {
        if($request->ajax()) {
            $req = RequestCompany::find($request->input('idC'));
            $new_date_arrive = $req->date_arrive;
            $new_date_request = $req->date_request;
            $new_date_end = $req->date_end;


            if($req->date_request!= "") {
                $new_date_request = date('Y-m-d\TH:i', strtotime($req->date_request));

            }
            if($req->date_arrive != "") {
                $new_date_arrive = date('Y-m-d\TH:i', strtotime($req->date_arrive));
            }
            if($req->date_end != "") {
                $new_date_end = date('Y-m-d\TH:i', strtotime($req->date_end));

            }
            if($req->paradas == "") {
                $paradas = "vacio";
            }else {
                $paradas = $req->paradas;
            }
            $response = [
                'id' => $req->id,
                'payment_type_id' =>   $req->payment_type_id,
                'date_request' => $new_date_request,
                'date_arrive' =>  $new_date_arrive,
                'date_end' => $new_date_end,
                'peaje' => $req->peaje,
                'parqueo' => $req->parqueo,
                'tespera' => $req->tespera,
                'paradas' => $paradas,
                "obs" => $req->obs
            ];
            return response()->json([$response]);
        }
    }
    public function update_detail_request_company(Rq $request) {
        $paradas = $request->input("paradas");
        $arrParadas = array();
        $parqueo = 0;
        $pejae = 0;
        $tpesra = 0;
        if( $request->input("peaje") != "") {
            $pejae = $request->input("peaje");
        }
        if( $request->input("parqueo") !="") {
            $parqueo = $request->input("parqueo");
        }
        if( $request->input("tespera") != "") {
            $tpesra = $request->input("tespera");
        }
        $req = RequestCompany::find($request->input('idRequest'));
//        $req->update($req->all());
        $new_date_request = date('Y-m-d\TH:i', strtotime($request->input('date_request')));
        $new_date_arrive = date('Y-m-d\TH:i', strtotime($request->input('date_arrive')));
        $new_date_end = date('Y-m-d H:i', strtotime($request->input('date_end')));
        $req->date_request = $new_date_request;
        $req->date_arrive = $new_date_arrive;
        $req->date_end = $new_date_end;
        $req->payment_type_id = $request->input('payment_type_id');
        $req->parqueo = $request->input('parqueo');
        $req->peaje = $request->input('peaje');
        $req->tespera = $request->input('tespera');
//        $req->obs = $request->input("obs");
//        $req->tespera = $request->input('tespera');
        $req->cost_provider = $req->cost_provider + $parqueo + $pejae + $tpesra;
        $pTotal = $req->cost_amount +  $parqueo + $pejae + $tpesra;
        $req->pTotal = $pTotal;
        $req->obs = $request->input("obs");

        if($paradas[0] != "") {
            for($i = 0; $i < count($paradas); $i++) {
                $arrParadas[] = $paradas[$i];
            }
            $req->paradas = json_encode($arrParadas);
        }else {
            $req->paradas =null;
        }
        $req->save();
        return back();
    }








    public  function rememberRequest() {
//        $reqsClients = Request::where("is_view", 0)->get();
//        $reqsCompanies= RequestCompany::where("is_view", 0)->get();
        $date = date("Y-m-d");
        $reqsClients = DB::select("SELECT * FROM requests WHERE date(date_arrive) >= '$date' and is_view = 0  and cost_amount is NULL and active = 1");
        $reqsCompanies=  DB::select("SELECT * FROM requests_companies WHERE date(date_arrive) >= '$date' and is_view = 0 and active = 1  and cost_amount is NULL");

        $dataClient = array();
        $dataCompany = array();
        foreach ($reqsClients as $reqClient) {

            $dataClient[] = [ "id" => $reqClient->id ];
        }

        foreach ($reqsCompanies as $reqCompany) {

                $dataCompany[] = [ "idC" => $reqCompany->id ];

        }
        $dataRequest = [
            "client" => $dataClient,
            "company" => $dataCompany

        ];
        return $dataRequest;
    }
    public  function getDataForId(Rq $request) {
            if($request -> ajax()) {
                    $ids = $request->input('json_ids');

//                        for( $i = 0; $i < count($ids["client"]); $i++) {
//                            $idCli = $ids["client"][$i]["id"];
//                            if($idCli != 0) {
//                                $request_clients =  Request::find($idCli);
//                                $request_clients->is_view = 1;
//                                $request_clients->save();
//                            }
//
//                        }

//
//                for( $i = 0; $i < count($ids["company"]); $i++) {
//                    $idComp = $ids["company"][$i]["idC"];
//                    if($idComp != 0) {
//                        $requests_company = RequestCompany::find($idComp);
//                        $requests_company->is_view = 1;
//                        $requests_company->save();
//                    }
//
//
//
//                }
                    return  response() ->json([$request->input('json_ids')]);

            }
    }

    public function newClientes() {
        $clients = Clients::where("is_aproval", 0)->get();
        $company = Company::where("is_aproval", 0)->get();
        $arrNew = [
            "clients" => count($clients),
            "company" => count($company)
        ];
        return $arrNew;
    }
    public  function get_type_user(Rq $request) {
        if($request->ajax()) {
            $id = $request->input("id");
            $types = DB::select("select type_payments.id, type_payments.type_payment from type_payments INNER  JOIN 
                  settings_payments_user on settings_payments_user.id_payment = type_payments.id where settings_payments_user.id_user = $id");
            $html = "<option>Tipos de Pago</option>";
             if( count( $types) > 0 ) {
                 foreach ( $types as $type) {
                     $html.= "<option value='{$type->id}'>{$type->type_payment}</option>";
                 }
             }
             return response()->json(["html" => $html]);
        }
    }
}
