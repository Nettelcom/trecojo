<?php

namespace App\Http\Controllers\Admin;

use App\CarCompanyController;
use App\Clients;
use App\Company;
use App\RequestCompany;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Request as Req;
use App\Owner;
use App\Provider;
use App\Cartype;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{

    public function redirect()
    {
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect(config('backpack.base.route_prefix').'/dashboard');
    }
    public function show_requests(){
        $req = Req::where('active',1)->paginate(10);
        $providers = Provider::all();
        $payments = DB::table('type_payments')->get();
        $clients = Clients::all();

        return view('request',compact('req', 'providers','payments', 'clients'));
    }
    public  function show_request_company() {
        $companies = Company::all();
        $providers = Provider::all();
        $payments = DB::table('type_payments')->get();
        $req_companies = RequestCompany::where('active',1)->paginate(10);

        return view('request-company', compact('companies', 'req_companies', 'providers', 'payments'));
    }

     public function show_owners(){
        $users=Owner::simplePaginate(10);
        return view('owners',compact('users'));
    }
    public function show_providers(){
        $providers=Provider::simplePaginate(10);
        return view('providers',compact('providers'));
    }
    public function show_car_types(){
        $cartypes = Cartype::paginate(10);
        $carCompanies = CarCompanyController::paginate(10);
        return view('car-types',compact('cartypes', 'carCompanies'));
    }
    public function show_map_view(){
        return view('maps');
    }
    public function show_general_settings(){
        return view('settings');
    }
    public  function show_company() {
        $companies = Company::simplePaginate(10);
        return view('company', compact('companies'));
    }
    public function show_payments() {

        $clients = \App\Request::where('status_request', 1)->where('is_paint', 1)->get();
        $companies = RequestCompany::where('status_request', 1)->where('is_paint', 1)->get();

        $clientsL = \App\Request::where('status_request', 1)->where('is_paint', 1)->paginate(5);
        $companiesL = RequestCompany::where('status_request', 1)->where('is_paint', 1)->paginate(5);
        $compas= Company::all();

        $providers = Provider::all();
        $payments = DB::table('type_payments')->get();
        $clients_request = Clients::all();


        $allPayment = 0 ;
        $contado = 0;
        $tarjeta = 0;
        $otros = 0;
        foreach ($clients as $client) {
            if( $client->status_request == 1) {
                $allPayment += $client->cost_amount;
            }
           if($client->payment_type_id == 1 && $client->status_request == 1) {
               $contado += $client->cost_amount;
           }
            if($client->payment_type_id == 2 && $client->status_request == 1) {
                $tarjeta += $client->cost_amount;
            }
            if($client->payment_type_id == 3 && $client->status_request == 1) {
                $otros += $client->cost_amount;
            }
        }
        foreach ($companies as $company) {
            if( $company->status_request == 1) {
                $allPayment += $client->cost_amount;
            }
            if($company->payment_type_id == 1 && $company->status_request == 1) {
                $contado += $client->cost_amount;
            }
            if($company->payment_type_id == 2 && $company->status_request == 1) {
                $tarjeta += $client->cost_amount;
            }
            if($company->payment_type_id == 3 && $company->status_request == 1) {
                $otros += $client->cost_amount;
            }
        }
        $costs_amounts = [
          'all' => $allPayment,
          'contado' => $contado,
          'tarjeta' => $tarjeta,
          'otros' => $otros
        ];
        return view('payments', compact('costs_amounts','clientsL', 'companiesL', 'providers', 'payments', 'clients_request', 'compas'));


    }
}
