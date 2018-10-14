<?php

namespace App\Http\Controllers\Admin;

use App\Request;
use App\RequestCompany;
use Carbon\Carbon;
use Illuminate\Http\Request as Rq;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    public  function update_data_request(Rq $request) {
        $req = Request::find($request->input('idRequest'));
        $req->update($request->all());
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
            $response = [
                'id' => $req->id,
                'payment_type_id' =>   $req->payment_type_id,
                'date_request' => $new_date_request,
                'date_arrive' =>  $new_date_arrive,
                'date_end' => $new_date_end
            ];
            return response()->json([$response]);
        }
    }
    public  function update_detail_request(Rq $request) {
        $req = Request::find($request->input('idRequest'));
//        $req->update($req->all());
        $new_date_request = date('Y-m-d\TH:i', strtotime($request->input('date_request')));
        $new_date_arrive = date('Y-m-d\TH:i', strtotime($request->input('date_arrive')));
        $new_date_end = date('Y-m-d H:i', strtotime($request->input('date_end')));
        $req->date_request = $new_date_request;
        $req->date_arrive = $new_date_arrive;
        $req->date_end = $new_date_end;
        $req->payment_type_id = $request->input('payment_type_id');
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
            $response = [
                'id' => $req->id,
                'payment_type_id' =>   $req->payment_type_id,
                'date_request' => $new_date_request,
                'date_arrive' =>  $new_date_arrive,
                'date_end' => $new_date_end
            ];
            return response()->json([$response]);
        }
    }
    public function update_detail_request_company(Rq $request) {
        $req = RequestCompany::find($request->input('idRequest'));
//        $req->update($req->all());
        $new_date_request = date('Y-m-d\TH:i', strtotime($request->input('date_request')));
        $new_date_arrive = date('Y-m-d\TH:i', strtotime($request->input('date_arrive')));
        $new_date_end = date('Y-m-d H:i', strtotime($request->input('date_end')));
        $req->date_request = $new_date_request;
        $req->date_arrive = $new_date_arrive;
        $req->date_end = $new_date_end;
        $req->payment_type_id = $request->input('payment_type_id');
        $req->save();
        return back();
    }








    public  function rememberRequest() {
//        $reqsClients = Request::where("is_view", 0)->get();
//        $reqsCompanies= RequestCompany::where("is_view", 0)->get();
        $date = date("Y-m-d");
        $reqsClients = DB::select("SELECT * FROM requests WHERE date(date_arrive) >= '$date' and is_view = 0 ");
        $reqsCompanies=  DB::select("SELECT * FROM requests_companies WHERE date(date_arrive) >= '$date' and is_view = 0");

        $dataClient []= ["id" => 0];
        $dataCompany []= ["idC" => 0];
        foreach ($reqsClients as $reqClient) {

                    $dataClient[] =
                        [
                            "id" => $reqClient->id,
                        ];

        }

        foreach ($reqsCompanies as $reqCompany) {

                $dataCompany[] = [
                    "idC" => $reqCompany->id,
                ];

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
}
