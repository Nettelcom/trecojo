<?php

namespace App\Http\Controllers\Admin;

use App\Request;
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

}
