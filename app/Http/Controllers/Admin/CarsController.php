<?php

namespace App\Http\Controllers\Admin;

use App\Cartype;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarsController extends Controller
{
    public function add_cars(Request $request) {
        $visible = 1;
        $car = new Cartype;
        $car->type = $request->input('type');
//        $car->base_distance = $request->input('base_distance');
//        $car->marca = $request->input('marca');
        $car->modelo = $request->input('modelo');
        $car->color = $request->input('color');
        $car->anio = $request->input('anio');
        $car->seat_capacity = $request->input('seat_capacity');
        $car->placa = $request->input('placa');
        $car->visibility_status = $visible;
        $car->save();
        return back();

    }
    public function show_car(Request $request) {
        if( $request->ajax()) {
           $car = Cartype::find($request->input('id_c'));
           return response()->json($car);
        }

    }
    public function edit_car(Request $request) {
        $visibility =  0;
        if($request->input('visibility_status') == "on") {
            $visibility =  1;
        }
       $car = \App\Cartype::find($request->input('id'));
        $car->type = $request->input('type');
//        $car->base_distance = $request->input('base_distance');
//        $car->marca = $request->input('marca');
        $car->modelo = $request->input('modelo');
        $car->color = $request->input('color');
        $car->anio = $request->input('anio');
        $car->seat_capacity = $request->input('seat_capacity');
        $car->placa = $request->input('placa');
        $car->visibility_status = $visibility;
        $car->save();
        return back();
    }
    public  function delete_cars($id) {
        $car = \App\Cartype::find($id);
        $car->delete();
        return back();
    }
    public function filter_cars(Request $request) {
        $car = $request->input('txt_search');

        $cartypes=Cartype::where('type', 'like','%'.$car.'%')->paginate(10);
        if (count($cartypes) == 0) {
            $cartypes=Cartype::where('placa', '=', $car)->paginate(10);

        }
        return view('filter-cars',compact('cartypes'));
    }
}
