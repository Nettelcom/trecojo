<?php

namespace App\Http\Controllers\Admin;

use App\CarCompanyController;
use App\Clients;
use App\Company;
use App\RequestCompany;
use Carbon\Carbon;
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
//        die();
        return redirect(config('backpack.base.route_prefix').'/dashboard');

    }
    public function show_requests(){
        $req = Req::where('active',1)
                    ->where('status_travel', 1)
            ->where("is_courier", 0)
                    ->paginate(10);
        $req_courier = Req::where('active',1)
                                ->where('status_travel', 1)
                                ->where("is_courier", 1)
                               ->paginate(10);

        $providers = Provider::all();
        $payments = DB::table('type_payments')->get();
        $clients = Clients::all();
        $type_car = DB::select("select * from type_car");
        $car = Cartype::all();

        return view('request',compact('req', 'providers','payments', 'clients', 'type_car', 'car', 'req_courier'));
    }
    public  function show_request_company() {
        $companies = Company::all();
        $providers = Provider::all();
        $payments = DB::table('type_payments')->get();
        $clients = Clients::all();
        $car = Cartype::all();

        $req_companies = RequestCompany::where('active',1 )
                                    ->where('status_travel', 1)
                                    ->where('is_courier', 0)
                                ->paginate(10);


        $req_couriers = RequestCompany::where('active',1 )
            ->where('status_travel', 1)
            ->where('is_courier', 1)
            ->paginate(10);
        $type_car = DB::select("select * from type_car");

        return view('request-company', compact('companies', 'req_companies', 'providers', 'payments', 'clients', 'type_car','car', 'req_couriers'));
    }

     public function show_owners(){
        $users=Owner::simplePaginate(10);
        return view('owners',compact('users'));
    }
    public function show_providers(){
        $providers=Provider::simplePaginate(10);
        $type_car = DB::select("select * from type_car");
        return view('providers',compact('providers', 'type_car'));
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

        $clientsL = \App\Request::where('status_request', 1)->where('is_paint', 1)->get();
        $companiesL = RequestCompany::where('status_request', 1)->where('is_paint', 1)->get();



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
                $allPayment += $company->cost_amount;
            }
            if($company->payment_type_id == 1 && $company->status_request == 1) {
                $contado += $company->cost_amount;
            }
            if($company->payment_type_id == 2 && $company->status_request == 1) {
                $tarjeta += $company->cost_amount;
            }
            if($company->payment_type_id == 3 && $company->status_request == 1) {
                $otros += $company->cost_amount;
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

    public  function show_notifications() {
//        $reqsClients = Request::where("is_view", 0)->get();
        $date = date("Y-m-d");
        $car = Cartype::all();
        $companies = Company::all();
        $providers = Provider::all();
        $payments = DB::table('type_payments')->get();
        $clients = Clients::all();
        $type_car = DB::select("select * from type_car");
        $reqsClients = DB::select("SELECT * FROM requests WHERE date(date_arrive) >= '$date' and is_view = 0 and  is_view = 0 order by date_arrive");
        $reqsCompanies=  DB::select("SELECT * FROM requests_companies WHERE date(date_arrive) >= '$date' and is_view = 0 order by date_arrive ");
        $request = [];
        $req_company = [];
        foreach ($reqsClients as $reqClient) {
            $cDate = Carbon::parse($reqClient->date_arrive);
//            if($cDate->diffInDays() == 0) {
                $request[] =
                    [
                        "id" => $reqClient->id,
                        "client_id" => $reqClient->client_id,
                        "provider_id" => $reqClient->provider_id,
                        "status_request" => $reqClient->status_request,
                        "start_address" => $reqClient->start_address,
                        "end_address" =>$reqClient->end_address,
                        "cost_amount" => $reqClient->cost_amount,
                        "cost_provider" => $reqClient->cost_provider,
                        "margin" => $reqClient->margin,
                        "is_paint" => $reqClient->is_paint,
                        "date_arrive" => $reqClient->date_arrive,
                        "date_request" => $reqClient->date_request,
                        "date_end" => $reqClient->date_end,
                        "payment_type_id" => $reqClient->payment_type_id,
                        "id_type_car" => $reqClient->id_type_car,
                        "is_courier" => $reqClient->is_courier
                        ];
            }
//        }

        foreach ($reqsCompanies as $reqCompany) {
            $comDate = Carbon::parse($reqCompany->date_arrive);
//            if($comDate->diffInDays() == 0) {
                $req_company[] = [
                    "id" => $reqCompany->id,
                    "company_id" => $reqCompany->company_id,
                    "client_id" => $reqCompany->client_id,
                    "provider_id" => $reqCompany->provider_id,
                    "status_request" => $reqCompany->status_request,
                    "start_address" => $reqCompany->start_address,
                    "end_address" =>$reqCompany->end_address,
                    "cost_amount" => $reqCompany->cost_amount,
                    "cost_provider" => $reqCompany->cost_provider,
                    "margin" => $reqCompany->margin,
                    "is_paint" => $reqCompany->is_paint,
                    "date_arrive" => $reqCompany->date_arrive,
                    "date_request" => $reqCompany->date_request,
                    "date_end" => $reqCompany->date_end,
                    "payment_type_id" => $reqCompany->payment_type_id,
                    "id_type_car" => $reqCompany->id_type_car,
                    "is_courier" => $reqClient->is_courier
                ];
            }
//        }


        return view("notifications", compact('companies', 'providers', 'payments', 'clients', 'request', 'req_company','car', 'type_car'));
    }

    public  function show_margin(Request $request) {

        $clients = \App\Request::where('status_request', 1)->where('is_paint', 1)->get();
        $companies = RequestCompany::where('status_request', 1)->where('is_paint', 1)->get();

        $clientsL = \App\Request::where('status_request', 1)->where('is_paint', 1)->get();
        $companiesL = RequestCompany::where('status_request', 1)->where('is_paint', 1)->get();



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
                $allPayment += $client->margin;
            }
            if($client->payment_type_id == 1 && $client->status_request == 1) {
                $contado += $client->margin;
            }
            if($client->payment_type_id == 2 && $client->status_request == 1) {
                $tarjeta += $client->margin;
            }
            if($client->payment_type_id == 3 && $client->status_request == 1) {
                $otros += $client->margin;
            }
        }
        foreach ($companies as $company) {
            if( $company->status_request == 1) {
                $allPayment += $company->margin;
            }
            if($company->payment_type_id == 1 && $company->status_request == 1) {
                $contado += $company->margin;
            }
            if($company->payment_type_id == 2 && $company->status_request == 1) {
                $tarjeta += $company->margin;
            }
            if($company->payment_type_id == 3 && $company->status_request == 1) {
                $otros += $company->margin;
            }
        }
        $costs_amounts = [
            'all' => $allPayment,
            'contado' => $contado,
            'tarjeta' => $tarjeta,
            'otros' => $otros
        ];
        return view('margin', compact('costs_amounts','clientsL', 'companiesL', 'providers', 'payments', 'clients_request', 'compas'));

        //        return view('margin');
    }
}
