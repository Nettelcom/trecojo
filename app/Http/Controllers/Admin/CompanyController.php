<?php

namespace App\Http\Controllers\Admin;

use App\CarCompanyController;
use App\Clients;
use App\Company;
use App\CompanyUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public  function add_company(Request $request) {
//        dd($request->all());
        $rules = [
            'ruc_number' => 'required',
            'r_social' => 'required',
            'departamento' => 'required',
            'provincia' => 'required',
            'distrito' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
//            'pwd_company' => 'required|same:pwd_company_confirm'
        ];
        $messages = [

            'first_name.required' => "El nombre es requerido",
            'last_name.required' => "El apellido es requerido",
            'email.required' => "El correo es requerido",
            'r_social.required' => 'El RUC es requerido',
            'phone.required' => 'El número de teléfono es requerido',
            'pwd_company.required' => 'Contraseña Requerida',
//            'pwd_company.same' => 'Las contraseñas no coinciden'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if( $validator -> fails()) {
            return back()->withErrors($validator)->withInput();
        }else {
            $approval_status = 0;
            if( $request->input('approval_status') == "on") {
                $approval_status = 1;
            }
            $company =  new Company;
            $rc =  $request->input('ruc_number');
            $company->ruc = $rc;
            $company->r_social = $request->input('r_social');
            $company->departamento = $request->input('departamento');
            $company->provincia = $request->input('provincia');
            $company->distrito = $request->input('distrito');
            $company->address = $request->input('direccion');
            $company->first_name = $request->input('first_name');
            $company->last_name = $request->input('last_name');
            $company->phone = $request->input('phone');
            $company->email = $request->input('email');
            $company->status = $approval_status;
//            $company->pwd_company= md5($request->input('pwd_company'));
            $company->pwd_company = md5($request->input('phone')) ;
            $company->save();

            return back();
//            dd($request->input('ruc_number'));
        }

    }
    public  function delete_cars_company($id) {
        $car =  CarCompanyController::find($id);
        $car->delete();
        return back();
    }
    public  function show_car_company(Request $request) {
        if($request->ajax()) {
//            return $request->input('idCo');
            $car = CarCompanyController::find($request->input('idCo'));
            return response()->json($car);
        }
    }
    public  function add_car_company(Request $request) {
        $rules = [
            'anio' => "required",
            'type' => "required",
            'color' => "required",
            'seat_capacity' => "required",
            'placa' => "required"
        ];
        $messages = [
            'type.required' => "El tipo es requerido",
            'color.required' => "El color  es requerido",
            'anio.required' => "El año es  requerido",
            'seat_capacity.required' => "La capacidad del vehículo es requerida",
            'placa.required' => "La placa es requerida",
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if( $validator -> fails()) {
            return back()->withErrors($validator)->withInput();
        }else {
            $carC =  new CarCompanyController;
            $carC->placa = $request->input('placa');
            $carC->type = $request->input('type');
            $carC->id_emp = $request->input('idCompany');
            $carC->placa = $request->input('placa');
            $carC->modelo = $request->input('modelo');
            $carC->color = $request->input('color');
            $carC->anio = $request->input('anio');
            $carC->seat_capacity = $request->input('seat_capacity');
            $carC->visibility_status = 1;
            $carC->save();
            return back();
        }

    }
    public  function delete_company($id) {
        $company = Company::find($id);
        $company->delete();
        return back();
    }
    public  function show_edit_company(Request $request) {
        if($request->ajax()) {
            $company =  Company::find($request->input('idCom'));
            return response()->json($company);
        }
    }
    public  function  change_status_company($id) {
        $status = 0;
        $company = Company::find($id);
        if($company->status == 0) {
            $status = 1;
        }
        $company->status = $status;
        $company->save();
        return back();
    }
    public  function update_company(Request $request)
    {


        $rules = [
            'ruc_number' => 'required|min:11',
            'r_social' => 'required',
            'departamento' => 'required',
            'provincia' => 'required',
            'distrito' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ];
        $messages = [

            'first_name.required' => "El nombre es requerido",
            'last_name.required' => "El apellido es requerido",
            'email.required' => "El correo es requerido",
            'r_social.required' => 'El RUC es requerido',
            'phone.required' => 'El número de teléfono es requerido'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {


            $approval_status = 0;
            if ($request->input('approval_status') == "on") {
                $approval_status = 1;
            }
            $company = Company::find($request->input('idCompany'));
            $rc = $request->input('ruc_number');
            $company->ruc = $rc;
            $company->r_social = $request->input('r_social');
            $company->departamento = $request->input('departamento');
            $company->provincia = $request->input('provincia');
            $company->distrito = $request->input('distrito');
            $company->address = $request->input('direccion');
            $company->first_name = $request->input('first_name');
            $company->last_name = $request->input('last_name');
            $company->phone = $request->input('phone');
            $company->email = $request->input('email');
            $company->status = $approval_status;
            $company->save();
            return back();
        }
    }
    public function get_users_company(Request $request) {
//        $users_company = CompanyUsers::where('id_company', $request->input('id_company'))->get();
        $idC = $request->input('id_company');
         $users_company = DB::select("select clients.id, clients.first_name, clients.last_name from clients INNER JOIN company_users on clients.id = company_users.id_user
                 where company_users.id_company = $idC ");
        $types = DB::select("select type_payments.id, type_payments.type_payment from type_payments INNER  JOIN 
                  settings_payments_company on settings_payments_company.id_payment = type_payments.id where settings_payments_company.id_company = $idC");
         $html = "<option value='empty'>Usuarios De Empresa</option>";
        $type_html =  "<option>Tipos de Pago</option>";
         foreach ($users_company as $user ) {
             $html .= "<option value='{$user->id}'>";
             $html .= "{$user->first_name}  {$user->last_name}";
             $html .= "</option>";
         }
        if( count( $types) > 0 ) {
            foreach ( $types as $type) {
                $type_html.= "<option value='{$type->id}'>{$type->type_payment}</option>";
            }
        }

        return response()->json(["opts" => $html, "type_pa" => $type_html]);
    }
    public  function approval_status_company($id) {
        $client = Company::find($id);
        if($client->is_approval == 0) {
            $client-> is_aproval = 1;
        }else {
            $client->is_aproval = 0;
        }
        $client->save();
        return back();
    }

    public  function getTypePaymentsForCompany(Request $request) {
        if( $request->ajax() ) {
            $id = $request->input("id");

            $pymts = DB::select(" select settings_payments_company.id as id_setting, type_payments.id, type_payment from type_payments inner JOIN  settings_payments_company
 on settings_payments_company.id_payment = type_payments.id inner join company on settings_payments_company.id_company = company.id
 where settings_payments_company.id_company = $id");

            $noPymts = DB::select("SELECT t1.id,type_payment  FROM type_payments t1  
 WHERE   NOT EXISTS (SELECT NULL FROM  settings_payments_company t3
 WHERE t3.id_payment = t1.id  and t3.id_company = $id) ");
            $myPaymets = "";
            $outPaymets = "";
            if ( count($pymts) > 0 ) {
                foreach ($pymts as $pymt) {
                    $myPaymets .= "<tr >";
                    $myPaymets .= "<td  >{$pymt->type_payment}</td>";
                    $myPaymets .= "<td><a href='deletePaymentCompany/{$pymt->id_setting}' class='btn btn-danger'><i class='fa fa-trash'></i></a></td>";
                }
            }
            if ( count($noPymts ) > 0  ) {
                foreach ( $noPymts as $noPymt) {
                    if($noPymt->id == 1 || $noPymt->id == 2) {
                        $outPaymets .= "<tr >";
                        $outPaymets .= "<td >{$noPymt->type_payment}</td>";
                        $outPaymets .= "<td><a href='setPaymentCompany/{$id}/{$noPymt->id}' class='btn btn-success'><i class='fa fa-save'></i></a></td>";
                    }
                }
            }
            $response = [
                "myPayments" => $myPaymets,
                "noPayments" => $outPaymets
            ];
            return response()->json($response);

        }
    }
    public  function setPaymentCompany($idC, $idP) {
        $insert = DB::select("insert into settings_payments_company(id_payment, id_company)
                        values ($idP, $idC)");
        return back();
    }

    public  function deletePaymentCompany($id) {
        DB::select("delete from  settings_payments_company where id = $id");
        return  back();
    }
}
