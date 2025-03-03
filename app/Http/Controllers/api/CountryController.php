<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;


class CountryController extends Controller
{
    /**
     * Obtiene la lista de todos los países registrados.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $countries = Country::all();

        if ($countries->isEmpty()) {
            return response()->json([
                'result' => false,
                'msg' => "No hay países registrados."
            ], 404);
        }

        return response()->json([
            'result' => true,
            'msg' => "Lista de países obtenida exitosamente.",
            'data' => $countries
        ], 200);
    }

    /**
     * Registra un nuevo país en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country' => 'required|string|max:50',
        ], [
            'country.required' => 'El nombre del país es obligatorio.',
            'country.string' => 'El nombre del país debe ser una cadena de texto.',
            'country.max' => 'El nombre del país no puede tener más de 50 caracteres.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'msg' => "Error en la validación de datos.",
                'errors' => $validator->errors()
            ], 400);
        }

        $country = Country::create($request->only(['country']));

        return response()->json([
            'result' => true,
            'msg' => "País registrado con éxito.",
            'data' => $country
        ], 201);
    }

    /**
     * Muestra la información de un país específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $country = Country::find($id);

        if (!$country) {
            return response()->json([
                'result' => false,
                'msg' => "No se encontró el país especificado.",
            ], 404);
        }

        return response()->json([
            'result' => true,
            'msg' => "Información del país obtenida.",
            'data' => $country
        ], 200);
    }

    /**
     * Actualiza la información de un país existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'country' => 'required|string|max:50',
        ], [
            'country.required' => 'El nombre del país es obligatorio.',
            'country.string' => 'El nombre del país debe ser una cadena de texto.',
            'country.max' => 'El nombre del país no puede tener más de 50 caracteres.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'msg' => "Error en la validación de datos.",
                'errors' => $validator->errors()
            ], 400);
        }

        $country = Country::find($id);

        if (!$country) {
            return response()->json([
                'result' => false,
                'msg' => "No se encontró el país especificado.",
            ], 404);
        }

        $country->update($request->only(['country']));

        return response()->json([
            'result' => true,
            'msg' => "Información del país actualizada.",
            'data' => $country
        ], 200);
    }

    /**
     * Elimina un país de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $country = Country::find($id);

        if (!$country) {
            return response()->json([
                'result' => false,
                'msg' => "No se encontró el país especificado.",
            ], 404);
        }

        $country->delete();

        return response()->json([
            'result' => true,
            'msg' => "País eliminado exitosamente."
        ], 200);
    }
}
