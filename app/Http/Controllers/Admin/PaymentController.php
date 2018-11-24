<?php

namespace App\Http\Controllers\Admin;

use App\Clients;
use App\Company;
use App\Http\Requests\Request;
use App\Provider;
use App\RequestCompany;
use Illuminate\Http\Request as Rq;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function get_payments_for_type(Rq $request) {
        if ( $request->ajax() ) {
            if ($request->input('type') == 0) {
                $clientsL = \App\Request::where('status_request', 1)
                    ->where('is_paint', 1)->get();
                $companiesL = RequestCompany::where('status_request', 1)
                    ->where('is_paint', 1)->get();
            } else if ($request->input('type') == 1) {
                $type = 1;

                $clientsL = \App\Request::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->where('payment_type_id', $type)->get();
                $companiesL = RequestCompany::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->where('payment_type_id', $type)->get();
            } else if ($request->input('type') == 2) {
                $type = 2;

                $clientsL = \App\Request::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->where('payment_type_id', $type)->get();
                $companiesL = RequestCompany::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->where('payment_type_id', $type)->get();

            } else if ($request->input('type') == 3) {
                $type = 3;

                $clientsL = \App\Request::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->where('payment_type_id', $type)->get();
                $companiesL = RequestCompany::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->where('payment_type_id', $type)->get();
            }
            $compas = Company::all();
            $providers = Provider::all();
            $payments = DB::table('type_payments')->get();
            $clients_request = Clients::all();
            $client_html = "";
            $company_html = "";
            if (count($clientsL) > 0) {
                foreach ($clientsL as $clientL) {
                    $client_html .= "<tr>";
                    $client_html .= "<td>{$clientL->id}</td>";
                    $client_html .= "<td>{$clientL->date_arrive}</td>";
                    foreach ($clients_request as $client_request) {
                        if ($client_request->id == $clientL->client_id) {
                            $client_html .= "<td>{$client_request->fisrt_name} {$client_request->last_name}</td>";
                        }
                    }
                    foreach ($providers as $provider) {
                        if ($provider->id == $clientL->provider_id) {
                            $client_html .= "<td>{$provider->fisrt_name}  {$provider->last_name}</td>";
                        }
                    }
                    $client_html .= "<td>{$clientL->pTotal}</td>";
                    $client_html .= "<td>{$clientL->cost_provider}</td>";
                    $client_html .= "<td>{$clientL->margin}</td>";
                    foreach ($payments as $payment) {
                        if ($payment->id == $clientL->payment_type_id) {
                            $client_html .= "<td>{$payment->type_payment}</td>";
                        }
                    }
                    $client_html .= "<td>{$clientL->start_address}</td>";
                    $client_html .= "<td>{$clientL->end_address}</td>";
                    $client_html .= "<td>{$clientL->date_request}</td>";
//                    $client_html .= "<td>{$clientL->date_arrive}</td>";
                    $client_html .= "<td>{$clientL->date_end}</td>";
                    $client_html .= "</tr>";
                }
            } else {
                $client_html .= "<h1 style='text-align: center'>No hay registros</h1>";

            }

            if (count($companiesL) > 0) {

                foreach ($companiesL as $companyL) {
                    $company_html .= "<tr>";

                    $company_html .= "<td>{$companyL->id}</td>";
                    foreach ($compas as $compa) {
                        if ($compa->id == $companyL->company_id) {
                            $company_html .= "<td>{$compa->r_social} </td>";
                        }
                    }
                    foreach ($providers as $provider) {
                        if ($provider->id == $companyL->provider_id) {
                            $company_html .= "<td>{$provider->fisrt_name}  {$provider->last_name}</td>";
                        }
                    }
                    $company_html .= "<td>{$companyL->pTotal}</td>";
                    $company_html .= "<td>{$companyL->cost_provider}</td>";
                    $company_html .= "<td>{$companyL->margin}</td>";
                    foreach ($payments as $payment) {
                        if ($payment->id == $companyL->payment_type_id) {
                            $company_html .= "<td>{$payment->type_payment}</td>";
                        }
                    }
                    $company_html .= "<td>{$companyL->start_address}</td>";
                    $company_html .= "<td>{$companyL->end_address}</td>";
                    $company_html .= "<td>{$companyL->date_request}</td>";
                    $company_html .= "<td>{$companyL->date_arrive}</td>";
                    $company_html .= "<td>{$companyL->date_end}</td>";
                    $company_html .= "</tr>";
                }
            } else {
                $company_html .= "<h1 style='text-align: center'>No hay registros</h1>";

            }
            return response()->json([
                                            'client_html' => $client_html,
                                            'company_html' => $company_html
                                            ]);

        }
    }
    public  function filter_payments(Rq $request) {
//        dd($request->all());

        $allPayment = 0 ;
        $contado = 0;
        $tarjeta = 0;
        $otros = 0;

        $compas= Company::all();

        $providers = Provider::all();
        $payments = DB::table('type_payments')->get();
        $clients_request = Clients::all();

        $from = $request->input('date_1')." 00:00:00";
        $to = $request->input('date_2')." 23:59:59";

        if ($request->input('date_1') == "" && $request->input('date_2') == "" && $request->input('type_payment') == "") {
            $clientsL = \App\Request::where('status_request', 1)->where('is_paint', 1)->get();
            $companiesL = RequestCompany::where('status_request', 1)->where('is_paint', 1)->get();
                    foreach ($clientsL as $client) {
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
        foreach ($companiesL as $company) {
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

        } elseif($request->input('date_1') != "" && $request->input('date_2') == "" && $request->input('type_payment') == "") {

            $from = $request->input('date_1')." 00:00:00";
            $clientsL = DB::select("select * from requests where date_arrive >=  '$from' and is_paint = 1 ");

            $companiesL = DB::select("select * from requests_companies where date_arrive >=  '$from' and is_paint = 1 ");
            foreach ($clientsL as $client) {
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
            foreach ($companiesL as $company) {
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

        }elseif ($request->input('date_1') == "" && $request->input('date_2') != "" && $request->input('type_payment') == "") {
            $from = $request->input('date_2')." 00:00:00";
            $clientsL = DB::select("select * from requests where date_arrive >=  '$from' and is_paint = 1 ");

            $companiesL = DB::select("select * from requests_companies where date_arrive >=  '$from' and is_paint = 1 ");


            foreach ($clientsL as $client) {
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
            foreach ($companiesL as $company) {
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

        }elseif ($request->input('date_1') == "" && $request->input('date_2') != "" && $request->input('type_payment') != "") {
            $from = $request->input('date_2')." 00:00:00";
            $tipe = $request->input('type_payment') ;
            $clientsL = DB::select("select * from requests where date_arrive >=  '$from' and is_paint = 1 and payment_type_id = $tipe");

            $companiesL = DB::select("select * from requests_companies where date_arrive >=  '$from' and is_paint = 1  and payment_type_id = $tipe");

            foreach ($clientsL as $client) {
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
            foreach ($companiesL as $company) {
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

        }elseif ($request->input('date_1') == "" && $request->input('date_2') == "" && $request->input('type_payment') != "") {

            $tipe = $request->input('type_payment') ;

            $clientsL = DB::select("select * from requests where  is_paint = 1 and payment_type_id = $tipe");

            $companiesL = DB::select("select * from requests_companies where is_paint = 1  and payment_type_id = $tipe");
            foreach ($clientsL as $client) {
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
            foreach ($companiesL as $company) {
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



        }
        elseif ($request->input('date_1') != "" && $request->input('date_2') == "" && $request->input('type_payment') != "") {
            $from = $request->input('date_1')." 00:00:00";
            $tipe = $request->input('type_payment') ;
            $clientsL = DB::select("select * from requests where date_arrive >=  '$from' and is_paint = 1 and payment_type_id = $tipe");

            $companiesL = DB::select("select * from requests_companies where date_arrive >=  '$from' and is_paint = 1  and payment_type_id = $tipe");
            foreach ($clientsL as $client) {
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
            foreach ($companiesL as $company) {
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
        }
        else {

            $clientsL =  \App\Request::where('status_request', 1)
                ->where('is_paint', 1)->whereBetween("date_arrive", array($from, $to))->get();

            $companiesL= \App\RequestCompany::where('status_request', 1)
                ->where('is_paint', 1)->whereBetween("date_arrive", array($from, $to))->get();

            foreach ($clientsL as $client) {
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
            foreach ($companiesL as $company) {
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
        }
        $costs_amounts = [
            'all' => $allPayment,
            'contado' => $contado,
            'tarjeta' => $tarjeta,
            'otros' => $otros
        ];

//        return [
//            "users" => $rqUsers, "company" => $rqCompany];
        return view('payments', compact('costs_amounts','clientsL', 'companiesL', 'providers', 'payments', 'clients_request', 'compas'));


    }


    public  function get_margin_id (Request $request){
        if ( $request->ajax() ) {
            if ($request->input('type') == 0) {
                $clientsL = \App\Request::where('status_request', 1)
                    ->where('is_paint', 1)->get();
                $companiesL = RequestCompany::where('status_request', 1)
                    ->where('is_paint', 1)->get();
            } else if ($request->input('type') == 1) {
                $type = 1;

                $clientsL = \App\Request::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->where('payment_type_id', $type)->get();
                $companiesL = RequestCompany::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->where('payment_type_id', $type)->get();
            } else if ($request->input('type') == 2) {
                $type = 2;

                $clientsL = \App\Request::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->where('payment_type_id', $type)->get();
                $companiesL = RequestCompany::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->where('payment_type_id', $type)->get();

            } else if ($request->input('type') == 3) {
                $type = 3;

                $clientsL = \App\Request::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->where('payment_type_id', $type)->get();
                $companiesL = RequestCompany::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->where('payment_type_id', $type)->get();
            }
            $compas = Company::all();
            $providers = Provider::all();
            $payments = DB::table('type_payments')->get();
            $clients_request = Clients::all();
            $client_html = "";
            $company_html = "";
            if (count($clientsL) > 0) {
                foreach ($clientsL as $clientL) {
                    $client_html .= "<tr>";

                    $client_html .= "<td>{$clientL->id}</td>";
                    foreach ($clients_request as $client_request) {
                        if ($client_request->id == $clientL->client_id) {
                            $client_html .= "<td>{$client_request->fisrt_name} {$client_request->last_name}</td>";
                        }
                    }
                    foreach ($providers as $provider) {
                        if ($provider->id == $clientL->provider_id) {
                            $client_html .= "<td>{$provider->fisrt_name}  {$provider->last_name}</td>";
                        }
                    }
                    $client_html .= "<td>{$clientL->cost_amount}</td>";
                    $client_html .= "<td>{$clientL->cost_provider}</td>";
                    $client_html .= "<td>{$clientL->margin}</td>";
                    foreach ($payments as $payment) {
                        if ($payment->id == $clientL->payment_type_id) {
                            $client_html .= "<td>{$payment->type_payment}</td>";
                        }
                    }
                    $client_html .= "<td>{$clientL->start_address}</td>";
                    $client_html .= "<td>{$clientL->end_address}</td>";
                    $client_html .= "<td>{$clientL->date_request}</td>";
                    $client_html .= "<td>{$clientL->date_arrive}</td>";
                    $client_html .= "<td>{$clientL->date_end}</td>";
                    $client_html .= "</tr>";
                }
            } else {
                $client_html .= "<h1 style='text-align: center'>No hay registros</h1>";

            }

            if (count($companiesL) > 0) {

                foreach ($companiesL as $companyL) {
                    $company_html .= "<tr>";

                    $company_html .= "<td>{$companyL->id}</td>";
                    foreach ($compas as $compa) {
                        if ($compa->id == $companyL->company_id) {
                            $company_html .= "<td>{$compa->r_social} </td>";
                        }
                    }
                    foreach ($providers as $provider) {
                        if ($provider->id == $companyL->provider_id) {
                            $company_html .= "<td>{$provider->fisrt_name}  {$provider->last_name}</td>";
                        }
                    }
                    $company_html .= "<td>{$companyL->cost_amount}</td>";
                    $client_html .= "<td>{$clientL->cost_provider}</td>";
                    $client_html .= "<td>{$clientL->margin}</td>";
                    foreach ($payments as $payment) {
                        if ($payment->id == $companyL->payment_type_id) {
                            $company_html .= "<td>{$payment->type_payment}</td>";
                        }
                    }
                    $company_html .= "<td>{$companyL->start_address}</td>";
                    $company_html .= "<td>{$companyL->end_address}</td>";
                    $company_html .= "<td>{$companyL->date_request}</td>";
                    $company_html .= "<td>{$companyL->date_arrive}</td>";
                    $company_html .= "<td>{$companyL->date_end}</td>";
                    $company_html .= "</tr>";
                }
            } else {
                $company_html .= "<h1 style='text-align: center'>No hay registros</h1>";

            }
            return response()->json([
                'client_html' => $client_html,
                'company_html' => $company_html
            ]);

        }
    }



    public function filter_margin_payments(\Illuminate\Http\Request $request) {



        $allPayment = 0 ;
        $contado = 0;
        $tarjeta = 0;
        $otros = 0;

        $compas= Company::all();

        $providers = Provider::all();
        $payments = DB::table('type_payments')->get();
        $clients_request = Clients::all();

        $from = $request->input('date_1')." 00:00:00";
        $to = $request->input('date_2')." 23:59:59";

        if ($request->input('date_1') == "" && $request->input('date_2') == "" && $request->input('type_payment') == "") {
//            dump($request->all());
            $clientsL = \App\Request::where('status_request', 1)->where('is_paint', 1)->get();
            $companiesL = RequestCompany::where('status_request', 1)->where('is_paint', 1)->get();
            foreach ($clientsL as $client) {
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
            foreach ($companiesL as $company) {
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

        }
        elseif($request->input('type_payment') != "" && $request->input('date_1') == "" && $request->input('date_2') == "") {

             $tipe = $request->input('type_payment') ;

            $clientsL = DB::select("select * from requests where  is_paint = 1 and payment_type_id = $tipe");

            $companiesL = DB::select("select * from requests_companies where is_paint = 1  and payment_type_id = $tipe");
            foreach ($clientsL as $client) {
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
            foreach ($companiesL as $company) {
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

        }elseif($request->input('date_1') != "" && $request->input('date_2') == "" && $request->input('type_payment') == "") {

            $from = $request->input('date_1')." 00:00:00";
            $clientsL = DB::select("select * from requests where date_arrive >=  '$from' and is_paint = 1 ");

            $companiesL = DB::select("select * from requests_companies where date_arrive >=  '$from' and is_paint = 1 ");
            foreach ($clientsL as $client) {
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
            foreach ($companiesL as $company) {
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

        }elseif ($request->input('date_1') == "" && $request->input('date_2') != "" && $request->input('type_payment') == "") {
            $from = $request->input('date_2')." 00:00:00";
            $clientsL = DB::select("select * from requests where date_arrive >=  '$from' and is_paint = 1 ");

            $companiesL = DB::select("select * from requests_companies where date_arrive >=  '$from' and is_paint = 1 ");


            foreach ($clientsL as $client) {
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
            foreach ($companiesL as $company) {
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


        }

        elseif ($request->input('date_1') == "" && $request->input('date_2') != "" && $request->input('type_payment') != "") {

            $from = $request->input('date_2')." 00:00:00";
            $tipe = $request->input('type_payment') ;
            $clientsL = DB::select("select * from requests where date_arrive >=  '$from' and is_paint = 1 and payment_type_id = $tipe");

            $companiesL = DB::select("select * from requests_companies where date_arrive >=  '$from' and is_paint = 1  and payment_type_id = $tipe");

            foreach ($clientsL as $client) {
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
            foreach ($companiesL as $company) {
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


        }elseif ($request->input('date_1') != "" && $request->input('date_2') == "" && $request->input('type_payment') != "") {
            $from = $request->input('date_2')." 00:00:00";
            $tipe = $request->input('type_payment') ;
            $clientsL = DB::select("select * from requests where date_arrive >=  '$from' and is_paint = 1 and payment_type_id = $tipe");

            $companiesL = DB::select("select * from requests_companies where date_arrive >=  '$from' and is_paint = 1  and payment_type_id = $tipe");
            foreach ($clientsL as $client) {
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
            foreach ($companiesL as $company) {
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
        }
        else {

            $clientsL =  \App\Request::where('status_request', 1)
                ->where('is_paint', 1)->whereBetween("date_arrive", array($from, $to))->get();

            $companiesL= \App\RequestCompany::where('status_request', 1)
                ->where('is_paint', 1)->whereBetween("date_arrive", array($from, $to))->get();
            foreach ($clientsL as $client) {
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
            foreach ($companiesL as $company) {
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
        }
        $costs_amounts = [
            'all' => $allPayment,
            'contado' => $contado,
            'tarjeta' => $tarjeta,
            'otros' => $otros
        ];

//        return [
//            "users" => $rqUsers, "company" => $rqCompany];
        return view('margin', compact('costs_amounts','clientsL', 'companiesL', 'providers', 'payments', 'clients_request', 'compas'));


    }

}
