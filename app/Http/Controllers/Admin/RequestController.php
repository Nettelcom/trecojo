<?php

namespace App\Http\Controllers\Admin;

use App\Request;
use App\RequestCompany;
use Illuminate\Http\Request as Rq;
use App\Http\Controllers\Controller;

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

    public  function add_request_modal(Rq $request) {
        $req= new RequestCompany;
        $new_date_arrive = date('Y-m-d\TH:i', strtotime($request->input('date_arrive')));
        $req->company_id = $request->input('client_id');
        $req->payment_type_id = $request->input('client_id');
        $req->start_address = $request->input('start_address');
        $req->end_address = $request->input('end_address');
        $req->date_arrive = $new_date_arrive;
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
}
