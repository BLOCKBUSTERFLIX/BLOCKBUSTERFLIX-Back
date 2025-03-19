<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Obtiene la lista de categorías existentes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        if($categories->isEmpty()){
            return response()->json([
                'result' => false,
                'msg' => "No hay categorías."

            ], 404);
        }

        return response()->json([
            'result' => true,
            'msg' => "Lista de categorías obtenida exitosamente.",
            'data' => $categories
        ], 200);
    }

    /**
     * Registrar una nueva categoría.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ], [
            'name.required' =>'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
        ]);

        if($request->fails()){
            return response()->json([
                'result' => false,
                'msg' => "Error en la validación de datos.",
                'errors' => $validator->errors()
            ], 400);
        }

        $category = Category::create($request->only(['name']));

        return response()->json([
            'result' => true,
            'msg' => "Se ha registrado la categoría " . $category->name . "."
        ], 201);
    }

    /**
     * Obtener información de una categoría específica.
     * 
     * @param int $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $category = Category::find($id);

        if(!$category){
            return response()->json([
                'result' => false,
                'msg' => "No se encontró la categoría especificada.",
            ], 404); 
        }

        return response()->json([
            'result' => true,
            'msg' => "Información de la categoría " . $category->name . ".",
            'data' => $category
        ], 200);
    }

    /**
     * Actualizar información de una categoría existente.
     * 
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ], [
            'name.required' =>'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
        ]);

        if($request->fails()){
            return response()->json([
                'result' => false,
                'msg' => "Error en la validación de datos.",
                'errors' => $validator->errors()
            ], 400);
        }

        $category = Category::find($id);

        if(!$category){
            return response()->json([
                'result' => false,
                'msg' => "No se encontró la categoría especificada.",
            ], 404); 
        }

        $category->update($request->only(['name']));

        return response()->json([
            'result' => true,
            'msg' => "Información de la categoría " . $category->name . " actualizada.",
        ], 200);
    }

    /**
     * Eliminar una categoría de la base de datos.
     * 
     * @param int $id
     * @return void
     */
    public function destroy(int $id)
    {
        $category = Category::find($id);

        if(!$category){
            return response()->json([
                'result' => false,
                'msg' => "No se encontró la categoría especificada.",
            ], 404); 
        }

        $category->delete();

        return response()->json([
            'result' => true,
            'msg' => "Categoría eliminada exitosamente."
        ], 204);
    }
}
