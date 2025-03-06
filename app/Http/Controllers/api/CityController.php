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
                'errors' => 
            ]);
        }
        $city = City::create($request->only(['city', 'country_id']));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
