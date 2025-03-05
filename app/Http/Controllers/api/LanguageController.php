<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\Lenguage;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lenguages = Language::all();
        if(count($lenguages) <= 0){
            return response()->json([
                'result' => false,
                'msg' => "No hay lenguajes registrados."
            ], 404);
        }
        return response()->json([
            'result' => true,
            'msg' => "Lenguajes encontrados.",
            'data' => $lenguages
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'name' => "required|string|max:20"
        ], [
            'name.required' => 'El nombre del lenguaje es obligatorio.',
            'name.string' => 'El nombre del lenguaje debe ser una cadena de texto.',
            'name.max' => 'El nombre del lenguaje no puede tener más de 20 caracteres.',
        ]
        );
        if($validator->fails()){
            return response()->json([
                'result' => false,
                'msg' => "Los datos no cumplen.",
                'errors' => $validator->errors()
            ], 401);
        }

        $language = Language::create($request->only(['name']));
        return response()->json([
            'result' => true,
            'msg' => "Lenguaje registrado con éxito.",
            'data' => $language
        ], 201);

    }
    public function show(int $id)
    {
        $language = Language::find($id);
        if(!$language){
            return response()->json([
                'result' => false,
                'msg' => "No se encontro el lenguaje."
            ], 404);
        }
        return response()->json([
            'result' => true,
            'msg' => "Lenguaje encontrado.",
            'data' => $language
        ], 200);

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
