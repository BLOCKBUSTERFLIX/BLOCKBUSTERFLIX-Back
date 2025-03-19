<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories = Inventory::with('film', 'store')->get();

        if($inventories->isEmpty()){
            return response()->json([
                'result' => false,
                'msg' => "No hay inventario registrado."
            ], 404);
        }

        
        return response()->json([
            'result' => true,
            'msg' => "Lista de inventario obtenida exitosamente.",
            'data' => $inventories
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
        $validator = Validator::make($request->all(), [
            'film_id' => 'required|exists:films,id',
            'store_id' => 'required|exists:stores,id',
        ], [
            'film_id.required' => 'Se requiere una película.',
            'film_id.exists' => 'La película seleccionada no es válida.',
            'store_id.required' => 'Se requiere una tienda.',
            'store_id.exists' => 'La tienda seleccionada no es válida.',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'msg' => "Los datos no cumplen.",
                'errors' => $validator->errors()
            ], 421);
        }

        $inventory = Inventory::create($request->only('film_id', 'store_id'));
        return response()->json([
            'result' => true,
            'msg' => "Se registro el inventario de manera exitosa."
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $invetory = Inventory::with(['film', 'store'])->find($id);

        if(!$invetory){
            return response()->json([
                'result' => false,
                'msg' => "Inventario no encontrado."
            ]);
        }

        return response()->json([
            'result' => true,
            'msg' => "Infromación encontrada.",
            'data' => $invetory
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'film_id' => 'required|exists:films,id',
            'store_id' => 'required|exists:stores,id',
        ], [
            'film_id.required' => 'Se requiere una película.',
            'film_id.exists' => 'La película seleccionada no es válida.',
            'store_id.required' => 'Se requiere una tienda.',
            'store_id.exists' => 'La tienda seleccionada no es válida.',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'msg' => "Los datos no cumplen.",
                'errors' => $validator->errors()
            ], 421);
        }

        $invetory = Inventory::find($id);

        if(!$invetory){
            return response()->json([
                'result' => false,
                'msg' => "Inventario no encontrado."
            ]);
        }

        $invetory->update($request->only('film_id', 'store_id'));
        return response()->json([
            'result' => true,
            'msg' => "Se actualizaron los datos de manera exitosa.",
            'data' => $invetory
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $invetory = Inventory::find($id);

        if(!$invetory){
            return response()->json([
                'result' => false,
                'msg' => "Inventario no encontrado."
            ]);
        }

        $invetory->delete();

        
        return response()->json([
            'result' => true,
            'msg' => "Se elimino el inventario.",
        ]);
    }
}
