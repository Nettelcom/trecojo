<?php

namespace App\Http\Controllers\Admin;

use App\CarCompanyController;
use App\Clients;
use App\Company;
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
        $req = Req::all()->where('active',1);
        $providers = Provider::all();
        $payments = DB::table('type_payments')->get();
        $clients = Clients::all();
        return view('request',compact('req', 'providers','payments', 'clients'));
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
}
