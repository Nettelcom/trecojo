<?php

namespace App\Http\Controllers\Admin;

use App\Clients;
use App\Company;
use App\Provider;
use App\RequestCompany;
use Illuminate\Http\Request as Rq;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function get_payments_for_type(Rq $request) {
        if ($request->ajax()) {
            if ($request->input('type') == 0) {
                $clientsL = \App\Request::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->paginate(5);
                $companiesL = RequestCompany::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->paginate(5);
            } else if ($request->input('type') == 1) {
                $type = 1;

                $clientsL = \App\Request::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->where('payment_type_id', $type)
                    ->paginate(5);
                $companiesL = RequestCompany::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->where('payment_type_id', $type)
                    ->paginate(5);
            } else if ($request->input('type') == 2) {
                $type = 2;

                $clientsL = \App\Request::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->where('payment_type_id', $type)
                    ->paginate(5);
                $companiesL = RequestCompany::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->where('payment_type_id', $type)
                    ->paginate(5);

            } else if ($request->input('type') == 3) {
                $type = 3;

                $clientsL = \App\Request::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->where('payment_type_id', $type)
                    ->paginate(5);
                $companiesL = RequestCompany::where('status_request', 1)
                    ->where('is_paint', 1)
                    ->where('payment_type_id', $type)
                    ->paginate(5);
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
}
