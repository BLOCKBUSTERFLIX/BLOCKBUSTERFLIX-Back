<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActorController extends Controller
{
    /**
     * Obtiene la lista de todos los actores registrados.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $actors = Actor::all();

        if ($actors->isEmpty()) {
            return response()->json([
                'result' => false,
                'msg' => "No hay actores registrados."
            ], 404);
        }

        return response()->json([
            'result' => true,
            'msg' => "Lista de actores obtenida exitosamente.",
            'data' => $actors
        ], 200);
    }

    /**
     * Registra un nuevo actor en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ], [
            'first_name.required' => 'El nombre es obligatorio.',
            'first_name.string' => 'El nombre debe ser una cadena de texto.',
            'first_name.max' => 'El nombre no puede tener más de 255 caracteres.',

            'last_name.required' => 'El apellido es obligatorio.',
            'last_name.string' => 'El apellido debe ser una cadena de texto.',
            'last_name.max' => 'El apellido no puede tener más de 255 caracteres.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'msg' => "Error en la validación de datos.",
                'errors' => $validator->errors()
            ], 400);
        }

        $actor = Actor::create($request->only(['first_name', 'last_name']));

        return response()->json([
            'result' => true,
            'msg' => "Se ha registrado a " . $actor->first_name . ".",
        ], 201);
    }

    /**
     * Muestra la información de un actor específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $actor = Actor::find($id);

        if (!$actor) {
            return response()->json([
                'result' => false,
                'msg' => "No se encontró el actor especificado.",
            ], 404);
        }

        return response()->json([
            'result' => true,
            'msg' => "Información de " . $actor->first_name . ".",
            'data' => $actor
        ], 200);
    }

    /**
     * Actualiza la información de un actor existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ], [
            'first_name.required' => 'El nombre es obligatorio.',
            'first_name.string' => 'El nombre debe ser una cadena de texto.',
            'first_name.max' => 'El nombre no puede tener más de 255 caracteres.',

            'last_name.required' => 'El apellido es obligatorio.',
            'last_name.string' => 'El apellido debe ser una cadena de texto.',
            'last_name.max' => 'El apellido no puede tener más de 255 caracteres.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'msg' => "Error en la validación de datos.",
                'errors' => $validator->errors()
            ], 400);
        }

        $actor = Actor::find($id);

        if (!$actor) {
            return response()->json([
                'result' => false,
                'msg' => "No se encontró el actor especificado.",
            ], 404);
        }

        $actor->update($request->only(['first_name', 'last_name']));

        return response()->json([
            'result' => true,
            'msg' => "Información de " . $actor->first_name . " actualizada.",
        ], 200);
    }

    /**
     * Elimina un actor de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $actor = Actor::find($id);

        if (!$actor) {
            return response()->json([
                'result' => false,
                'msg' => "No se encontró el actor especificado.",
            ], 404);
        }

        $actor->delete();

        return response()->json([
            'result' => true,
            'msg' => "Actor eliminado exitosamente."
        ], 204);
    }
}
