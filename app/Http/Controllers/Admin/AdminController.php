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
        $req_courier = Req::where('active',1)
                                ->where('status_travel', 1)
                                ->where("is_courier", 1)
                               ->paginate(10);
        $req = Req::where('active',1)
            ->where('status_travel', 1)
            ->where("is_courier", 0)
            ->paginate(10);

        $providers = Provider::all();
        $payments = DB::table('type_payments')->get();
        $clients = Clients::all();
        $type_car = DB::select("select * from type_car");
        $car = Cartype::all();
//        dump($req);
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
        $providers=Provider::paginate(2);
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
        $companies = Company::where("is_aproval", 1)->paginate(10);
        $pendients = Company::where("is_aproval", 0)->paginate(10);
        return view('company', compact('companies', 'pendients'));
    }
    public function show_payments() {

        $clients = \App\Request::where('status_request', 1)->where('is_paint', 1)
            ->whereDate("date_arrive",'=',date("Y-m-d"))
            ->get();
        $companies = RequestCompany::where('status_request', 1)->where('is_paint', 1)
          -> whereDate("date_arrive",'=',date("Y-m-d"))
            ->get();

        $clientsL = \App\Request::where('status_request', 1)->where('is_paint', 1)
            ->whereDate("date_arrive",'=',date("Y-m-d"))
            ->get();
        $companiesL = RequestCompany::where('status_request', 1)->where('is_paint', 1)
            ->whereDate("date_arrive",'=',date("Y-m-d"))->get();



        $compas= Company::all();

        $providers = Provider::all();
        $payments = DB::table('type_payments')->get();
        $clients_request = Clients::all();


        $allPayment = 0 ;
        $contado = 0;
        $credito = 0;
        $trans = 0;
        $depo = 0;
        $conductores = 0;
        $margin = 0;
        foreach ($clients as $client) {
            if( $client->status_request == 1) {
                $allPayment += $client->pTotal;
                $conductores += $client->cost_provider;
                $margin += $client->margin;
            }
           if($client->payment_type_id == 1 && $client->status_request == 1) {
               $contado += $client->pTotal;

           }
            if($client->payment_type_id == 2 && $client->status_request == 1) {
                $credito += $client->pTotal;

            }
            if($client->payment_type_id == 3 && $client->status_request == 1) {
                $trans += $client->pTotal;
            }
            if($client->payment_type_id == 4 && $client->status_request == 1) {
                $depo += $client->pTotal;
            }
        }
        foreach ($companies as $company) {
            if( $company->status_request == 1) {
                $allPayment += $company->pTotal;
                $conductores += $company->cost_provider;
                $margin += $company->margin;
            }
            if($company->payment_type_id == 1 && $company->status_request == 1) {
                $contado += $company->pTotal;
            }

            if($company->payment_type_id == 2 && $company->status_request == 1) {
            $credito += $company->pTotal;
           }

            if($company->payment_type_id == 3 && $company->status_request == 1) {
                $trans += $company->pTotal;
            }
            if($company->payment_type_id == 4 && $company->status_request == 1) {
                $depo += $company->pTotal;
            }
        }
        $costs_amounts = [
          'all' => $allPayment,
          'contado' => $contado,
          'trans' => $trans,
          'depo' => $depo,
            'credito' => $credito,
           'conductores' => $conductores,
           'margin' => $allPayment - $conductores
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
        $reqsClients = DB::select("SELECT * FROM requests WHERE date(date_arrive) >= '$date' 
          and is_view = 0 and  is_view = 0 and active = 1 and cost_amount is null  order by date_arrive");
        $reqsCompanies=  DB::select("SELECT * FROM requests_companies WHERE date(date_arrive) >= '$date'
      and is_view = 0 and active = 1 and cost_amount is NULL order by date_arrive ");
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
                        "is_courier" => $reqClient->is_courier,
                        "pTotal" => $reqClient->pTotal
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
                    "is_courier" => $reqCompany->is_courier,
                    "pTotal" => $reqCompany->pTotal,

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

    public  function show_reports() {
        $providers = Provider::all();
        $companies = Company::where("is_aproval", 1)->get();
        $clients = Clients::where("is_aproval", 1)->get();
        return view( "reports", compact('providers', 'companies','clients'));
    }

    public  function report_clients(Request $request) {
        $idProvider = $request->input("id_provider");

//    return $request->all();
        if( $request->input("fecha1") == "" && $request->input("fecha2") == "" && $idProvider != "") {
            $reports = DB::select("select clients.first_name, clients.last_name,clients.address,providers.first_name as name_provider,
                                             providers.last_name as last_name_provider,requests.date_arrive,requests.start_address,
                                            requests.end_address,requests.cost_amount,requests.cost_provider,requests.paradas,requests.peaje,
                                            requests.parqueo,providers.number_acount, requests.tespera,requests.pTotal, requests.obs,requests.is_paint from requests INNER JOIN
                                            providers on providers.id = requests.provider_id INNER JOIN
                                            clients on clients.id = requests.client_id where providers.id = $idProvider 
                                            and requests.status_request = 1;");
            $pTotal =  DB::select("select sum(requests.pTotal) as pTotal from requests  INNER JOIN
                                            providers on providers.id = requests.provider_id where providers.id = $idProvider 
                                            and requests.status_request = 1");
        }elseif( $request->input("fecha1") != "" && $request->input("fecha2") == "" && $idProvider != "") {
            $fecha1 = $request->input("fecha1") ;
            $reports = DB::select("select clients.first_name, clients.last_name,clients.address,providers.first_name as name_provider,
                                             providers.last_name as last_name_provider,requests.date_arrive,requests.start_address,
                                            requests.end_address,requests.cost_amount,requests.cost_provider,requests.paradas,requests.peaje,
                                            requests.parqueo,providers.number_acount, requests.tespera,requests.pTotal,requests.obs,requests.is_paint from requests INNER JOIN
                                            providers on providers.id = requests.provider_id INNER JOIN
                                            clients on clients.id = requests.client_id where providers.id = $idProvider 
                                            and requests.status_request = 1 and date_arrive > '$fecha1'");
            $pTotal =  DB::select("select sum(requests.pTotal) as pTotal from requests  INNER JOIN
                                            providers on providers.id = requests.provider_id where providers.id = $idProvider 
                                            and requests.status_request = 1 and date_arrive > '$fecha1'");
        }elseif(  $request->input("fecha1") != "" && $request->input("fecha2") != "" && $idProvider != ""  ) {
            $fecha1 = $request->input("fecha1") ;
            $fecha2 = $request->input("fecha2") ;
            $reports = DB::select("select clients.first_name, clients.last_name,clients.address,providers.first_name as name_provider,
                                             providers.last_name as last_name_provider,providers.number_acount,requests.date_arrive,requests.start_address,
                                            requests.end_address,requests.cost_amount,requests.cost_provider,requests.paradas,requests.peaje,
                                            requests.parqueo,providers.number_acount ,requests.tespera,requests.pTotal,requests.obs,requests.is_paint from requests INNER JOIN
                                            providers on providers.id = requests.provider_id INNER JOIN
                                            clients on clients.id = requests.client_id where providers.id = $idProvider and requests.is_paint = 1
                                            and requests.status_request = 1 and date_arrive > '$fecha1'  and date_arrive < '$fecha2'   ");
            $pTotal =  DB::select("select sum(requests.pTotal) as pTotal from requests  INNER JOIN
                                            providers on providers.id = requests.provider_id where providers.id = $idProvider 
                                            and requests.status_request = 1 and date_arrive > '$fecha1' and date_arrive < '$fecha2'  ");
        }elseif( $request->input("fecha1") == "" && $request->input("fecha2") == "" && $idProvider == ""  ) {
            $reports = DB::select("select clients.first_name, clients.last_name,clients.address,providers.first_name as name_provider,
                                             providers.last_name as last_name_provider,requests.date_arrive,requests.start_address,
                                            requests.end_address,requests.cost_amount,requests.cost_provider,requests.paradas,requests.peaje,
                                            requests.parqueo,providers.number_acount, requests.tespera,requests.pTotal,requests.obs,requests.is_paint from requests INNER JOIN
                                            providers on providers.id = requests.provider_id INNER JOIN
                                            clients on clients.id = requests.client_id where requests.status_request = 1 ");
            $pTotal =  DB::select("select sum(requests.pTotal) as pTotal from requests  INNER JOIN
                                            providers on providers.id = requests.provider_id where  requests.status_request = 1 ");
        }

        return view("report_file", compact( 'reports', 'pTotal'));
     }
     public  function report_company( Request $request ) {
        $idCompany = $request->input("id_company");
        if( $idCompany != "" && $request->input("fecha1") == "" && $request->input("fecha2") == "" ) {
            $reports = DB::select("select clients.first_name, clients.last_name,clients.address,providers.first_name as name_provider,
                                             providers.last_name as last_name_provider,requests_companies.date_arrive,requests_companies.start_address,
                                            requests_companies.end_address,requests_companies.cost_amount,requests_companies.cost_provider,
                                            requests_companies.paradas,requests_companies.peaje,requests_companies.parqueo,providers.number_acount,
                                             requests_companies.tespera,requests_companies.pTotal, requests_companies.obs, company.r_social
                                             ,requests_companies.is_paint from requests_companies INNER JOIN
                                            providers on providers.id = requests_companies.provider_id INNER JOIN 
                                            clients on clients.id = requests_companies.client_id INNER  JOIN 
                                             company on requests_companies.company_id = company.id WHERE 
                                             requests_companies.company_id = $idCompany and 
                                            and requests_companies.status_request = 1");
            $pTotal =  DB::select("select sum(requests_companies.pTotal) as pTotal from requests_companies  where 
                            requests_companies.company_id = $idCompany  and requests_companies.status_request = 1");
        }elseif( $idCompany != "" && $request->input("fecha1") != "" && $request->input("fecha2") == "" ) {
            $fecha1 =  $request->input("fecha1");
            $reports = DB::select("select clients.first_name, clients.last_name,clients.address,providers.first_name as name_provider,
                                             providers.last_name as last_name_provider,requests_companies.date_arrive,requests_companies.start_address,
                                            requests_companies.end_address,requests_companies.cost_amount,requests_companies.cost_provider,
                                            requests_companies.paradas,requests_companies.peaje,requests_companies.parqueo,providers.number_acount,
                                             requests_companies.tespera,requests_companies.pTotal, requests_companies.obs, company.r_social,requests_companies.is_paint from requests_companies INNER JOIN
                                            providers on providers.id = requests_companies.provider_id INNER JOIN
                                            clients on clients.id = requests_companies.client_id INNER  JOIN 
                                             company on requests_companies.company_id = company.id  where requests_companies.company_id = $idCompany
                                            and requests_companies.status_request = 1 and date_arrive > '$fecha1'");
            $pTotal =  DB::select("select sum(requests_companies.pTotal) as pTotal from requests_companies  where 
                            requests_companies.company_id = $idCompany and requests_companies.status_request = 1
                              and date_arrive > '$fecha1'");
        }elseif( $idCompany != "" && $request->input("fecha1") != "" && $request->input("fecha2") != "" ) {
            $fecha1 = $request->input("fecha1");
            $fecha2 = $request->input("fecha2");
            $reports = DB::select("select clients.first_name, clients.last_name,clients.address,providers.first_name as name_provider,
                                             providers.last_name as last_name_provider,requests_companies.date_arrive,requests_companies.start_address,
                                            requests_companies.end_address,requests_companies.cost_amount,requests_companies.cost_provider,
                                            requests_companies.paradas,requests_companies.peaje,requests_companies.parqueo,providers.number_acount,
                                             requests_companies.tespera,requests_companies.pTotal, requests_companies.obs, company.r_social,requests_companies.is_paint from requests_companies INNER JOIN
                                            providers on providers.id = requests_companies.provider_id INNER JOIN
                                            clients on clients.id = requests_companies.client_id  INNER  JOIN 
                                             company on requests_companies.company_id = company.id where requests_companies.company_id = $idCompany 
                                                           and requests_companies.status_request = 1 and date_arrive > '$fecha1' and   date_arrive < '$fecha2'");
            $pTotal = DB::select("select sum(requests_companies.pTotal) as pTotal from requests_companies  where 
                            requests_companies.company_id = $idCompany  and requests_companies.status_request = 1
                              and date_arrive > '$fecha1' and date_arrive < '$fecha2' ");
        }elseif ($idCompany == "" && $request->input("fecha1") == "" && $request->input("fecha2") == "") {
            $reports = DB::select("select clients.first_name, clients.last_name,clients.address,providers.first_name as name_provider,
                                             providers.last_name as last_name_provider,requests_companies.date_arrive,requests_companies.start_address,
                                            requests_companies.end_address,requests_companies.cost_amount,requests_companies.cost_provider,
                                            requests_companies.paradas,requests_companies.peaje,requests_companies.parqueo,providers.number_acount,
                                             requests_companies.tespera,requests_companies.pTotal, requests_companies.obs, company.r_social,requests_companies.is_paint from requests_companies INNER JOIN
                                            providers on providers.id = requests_companies.provider_id INNER JOIN
                                            clients on clients.id = requests_companies.client_id  INNER  JOIN 
                                             company on requests_companies.company_id = company.id where requests_companies.status_request = 1");
            $pTotal = DB::select("select sum(requests_companies.pTotal) as pTotal from requests_companies  where 
                                      requests_companies.status_request = 1");

        }elseif($idCompany == "" && $request->input("fecha1") != "" && $request->input("fecha2") != "") {
            $fecha1 = $request->input("fecha1");
            $fecha2 = $request->input("fecha2");
            $reports = DB::select("select clients.first_name, clients.last_name,clients.address,providers.first_name as name_provider,
                                             providers.last_name as last_name_provider,requests_companies.date_arrive,requests_companies.start_address,
                                            requests_companies.end_address,requests_companies.cost_amount,requests_companies.cost_provider,
                                            requests_companies.paradas,requests_companies.peaje,requests_companies.parqueo,providers.number_acount,
                                             requests_companies.tespera,requests_companies.pTotal, requests_companies.obs, company.r_social,requests_companies.is_paint from requests_companies INNER JOIN
                                            providers on providers.id = requests_companies.provider_id INNER JOIN
                                            clients on clients.id = requests_companies.client_id INNER  JOIN 
                                             company on requests_companies.company_id = company.id where requests_companies.status_request = 1 and date_arrive > '$fecha1' and   date_arrive < '$fecha2'");
            $pTotal = DB::select("select sum(requests_companies.pTotal) as pTotal from requests_companies  where 
                             requests_companies.is_paint = 1 
                              and date_arrive > '$fecha1' and date_arrive < '$fecha2' ");
        }
        return view("report_company", compact('reports', 'pTotal'));

    }

    public  function report_persona(Request $request) {
        $idClient = $request->input("id_client");
        $fecha1 = $request->input("fecha1");
        $fecha2= $request->input("fecha2");
        if( $idClient != "" && $fecha1 == "" && $fecha2 == "" ) {
            $reports = DB::select("select clients.first_name, clients.last_name,clients.address,providers.first_name as name_provider,
                                             providers.last_name as last_name_provider,requests.date_arrive,requests.start_address,
                                            requests.end_address,requests.cost_amount,requests.cost_provider,requests.paradas,requests.peaje,
                                            requests.parqueo,providers.number_acount, requests.tespera,requests.pTotal, requests.obs,requests.is_paint from requests INNER JOIN
                                            providers on providers.id = requests.provider_id INNER JOIN
                                            clients on clients.id = requests.client_id where clients.id = $idClient 
                                            and requests.status_request = 1;");
            $pTotal =  DB::select("select sum(requests.pTotal) as pTotal from requests  INNER JOIN
                                            clients on clients.id =  requests.client_id where clients.id = $idClient 
                                            and requests.status_request = 1");
        }elseif($idClient != "" && $fecha1 != "" && $fecha2 == "") {
            $reports = DB::select("select clients.first_name, clients.last_name,clients.address,providers.first_name as name_provider,
                                             providers.last_name as last_name_provider,requests.date_arrive,requests.start_address,
                                            requests.end_address,requests.cost_amount,requests.cost_provider,requests.paradas,requests.peaje,
                                            requests.parqueo,providers.number_acount, requests.tespera,requests.pTotal, requests.obs,requests.is_paint from requests INNER JOIN
                                            providers on providers.id = requests.provider_id INNER JOIN
                                            clients on clients.id = requests.client_id where clients.id = $idClient 
                                            and requests.status_request = 1 and date_arrive > '$fecha1';");
            $pTotal =  DB::select("select sum(requests.pTotal) as pTotal from requests  INNER JOIN
                                            clients on clients.id =  requests.client_id where clients.id = $idClient
                                            and requests.status_request = 1 and date_arrive > '$fecha1'");
        }elseif($idClient != "" && $fecha1 != "" && $fecha2 != "") {
            $reports = DB::select("select clients.first_name, clients.last_name,clients.address,providers.first_name as name_provider,
                                             providers.last_name as last_name_provider,requests.date_arrive,requests.start_address,
                                            requests.end_address,requests.cost_amount,requests.cost_provider,requests.paradas,requests.peaje,
                                            requests.parqueo,providers.number_acount, requests.tespera,requests.pTotal, requests.obs,requests.is_paint from requests INNER JOIN
                                            providers on providers.id = requests.provider_id INNER JOIN
                                            clients on clients.id = requests.client_id where clients.id = $idClient 
                                            and requests.status_request = 1 and date_arrive > '$fecha1' and date_arrive < '$fecha2'");
            $pTotal =  DB::select("select sum(requests.pTotal) as pTotal from requests  INNER JOIN
                                            clients on clients.id =  requests.client_id where clients.id = $idClient 
                                            and requests.status_request = 1 and date_arrive > '$fecha1' and date_arrive < '$fecha2'");
        }elseif($idClient == "" && $fecha1 == "" && $fecha2 == "") {
            $reports = DB::select("select clients.first_name, clients.last_name,clients.address,providers.first_name as name_provider,
                                             providers.last_name as last_name_provider,requests.date_arrive,requests.start_address,
                                            requests.end_address,requests.cost_amount,requests.cost_provider,requests.paradas,requests.peaje,
                                            requests.parqueo,providers.number_acount, requests.tespera,requests.pTotal, requests.obs,requests.is_paint from requests INNER JOIN
                                            providers on providers.id = requests.provider_id INNER JOIN
                                            clients on clients.id = requests.client_id where requests.status_request = 1");
            $pTotal =  DB::select("select sum(requests.pTotal) as pTotal from requests  INNER JOIN
                                            clients on clients.id = requests.client_id where  requests.status_request = 1");
        }elseif ($idClient == "" && $fecha1 != "" && $fecha2 == "")  {
        $reports = DB::select("select clients.first_name, clients.last_name,clients.address,providers.first_name as name_provider,
                                             providers.last_name as last_name_provider,requests.date_arrive,requests.start_address,
                                            requests.end_address,requests.cost_amount,requests.cost_provider,requests.paradas,requests.peaje,
                                            requests.parqueo,providers.number_acount, requests.tespera,requests.pTotal, requests.obs,requests.is_paint from requests INNER JOIN
                                            providers on providers.id = requests.provider_id INNER JOIN
                                            clients on clients.id = requests.client_id where requests.status_request = 1 and date_arrive > '$fecha1'");
        $pTotal =  DB::select("select sum(requests.pTotal) as pTotal from requests  INNER JOIN
                                            clients on clients.id = requests.client_id where  requests.status_request = 1 and date_arrive > '$fecha1'");
        }


        return view("report_person", compact('reports', 'pTotal'));
    }
}
