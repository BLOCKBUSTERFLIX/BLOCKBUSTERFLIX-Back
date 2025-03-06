<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function index()
    {
        $city = City::all();
        if(count($city) <= 0){
            return response()->json([
                'result' => false,
                'msg' => "No existen ciudades registradas"
            ], 404);
        }
        return response()->json([
            'result' => true,
            'msg' => "Ciudades disponibles."
        ], 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city' => 'required|string|max:50|unique:cities,city',
            'country_id' => 'required|exists:countries,id',
        ], [
            'city.required' => 'El nombre de la ciudad es obligatorio.',
            'city.string' => 'El nombre de la ciudad debe ser una cadena de texto.',
            'city.max' => 'El nombre de la ciudad no puede tener más de 50 caracteres.',
            'city.unique' => 'Ya existe una ciudad con ese nombre.',

            'country_id.required' => 'El país es obligatorio.',
            'country_id.exists' => 'El país seleccionado no existe en la base de datos.',
        ]);
        if($validator->fails()){
            return response()->json([
                'result' => false,
                'msg' => "Los datos no cumplen",
                'errors' => $validator->errors()
            ]);
        }
        $city = City::create($request->only(['city', 'country_id']));
        return response()->json([
            'result' => true,
            'msg' => "Ciudad registrada con éxito.",
            'data' => $city
        ], 201);

    }
    public function show($id)
    {
        $city = City::find($id);
        if(!$city){
            return response()->json([
                'result' => false,
                'msg' => "No se encontro la ciudad."
            ], 404);
        }
        return response()->json([
            'result' => true,
            'msg' => "Ciudad encontrada.",
            'data' => $city
        ], 200);
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'city' => 'required|string|max:50|unique:cities,city',
            'country_id' => 'required|exists:countries,id',
        ], [
            'city.required' => 'El nombre de la ciudad es obligatorio.',
            'city.string' => 'El nombre de la ciudad debe ser una cadena de texto.',
            'city.max' => 'El nombre de la ciudad no puede tener más de 50 caracteres.',
            'city.unique' => 'Ya existe una ciudad con ese nombre.',

            'country_id.required' => 'El país es obligatorio.',
            'country_id.exists' => 'El país seleccionado no existe en la base de datos.',
        ]);
        if($validator->fails()){
            return response()->json([
                'result' => false,
                'msg' => "Los datos no cumplen",
                'errors' => $validator->errors()
            ]);
        }
        $city = City::find($id);
        if(!$city){
            return response()->json([
                'result' => false,
                'msg' => "No se encontro la ciudad."
            ], 404);
        }
        $city->update($request->only(['city', 'country_id']));
        return response()->json([
            'result' => true,
            'msg' => "Se actualizó " . $city->city . " con éxito."
        ], 201);
    }
    public function destroy($id)
    {
        $city = City::find($id);
        if(!$city){
            return response()->json([
                'result' => false,
                'msg' => "No se encontro la ciudad."
            ], 404);
        }
        $city->delete();
        return response()->json([
            'result' => true,
            'msg' => "Se eliminó la ciudad " . $city->city. " con éxito."
        ], 200);
    }
}
