<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function index()
{
    // Cargar las relaciones 'staff' (gerente) y 'address' (dirección)
    $stores = Store::with(['staff', 'address'])->get();

    if ($stores->isEmpty()) {
        return response()->json([
            'result' => false,
            'msg' => "No hay tiendas registradas."
        ], 404);
    }

    // Transformar los datos para incluir el nombre del gerente y la dirección
    $storesData = $stores->map(function ($store) {
        return [
            'id' => $store->id,
            'manager_staff_id' => $store->staff ? $store->staff->first_name : null, // Nombre del gerente
            'address_id' => $store->address ? $store->address->address : null, // Dirección
            // Otros campos de la tienda si es necesario
        ];
    });

    return response()->json([
        'result' => true,
        'msg' => "Tiendas disponibles.",
        'data' => $storesData
    ]);
}
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'manager_staff_id' => 'required|exists:staff,id',
            'address_id' => 'required|exists:addresses,id'
        ], [
            'manager_staff_id.required' => 'El ID del gerente es obligatorio.',
            'manager_staff_id.exists' => 'El gerente debe existir en la tabla de staff.',
            'address_id.required' => 'El ID de la dirección es obligatorio.',
            'address_id.exists' => 'La dirección debe existir en la tabla de address.'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'msg' => "Error en la validación de datos.",
                'errors' => $validator->errors()
            ], 422);
        }

        $store = Store::create($request->only(['manager_staff_id', 'address_id']));
        
        return response()->json([
            'result' => true,
            'msg' => "Tienda creada con éxito.",
            'data' => $store
        ], 201);

    }

    public function show($id)
    {
        $store = Store::find($id);
        
        if (!$store) {
            return response()->json([
                'result' => false,
                'msg' => "No se encontró la tienda especificada.",
            ], 404);
        }
        return response()->json([
            'result' => true,
            'msg' => "Tienda encontrada.",
            'data' => $store
        ]);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'manager_staff_id' => 'required|exists:staff,id',
            'address_id' => 'required|exists:addresses,id'
        ], [
            'manager_staff_id.required' => 'El ID del gerente es obligatorio.',
            'manager_staff_id.exists' => 'El gerente debe existir en la tabla de staff.',
            'address_id.required' => 'El ID de la dirección es obligatorio.',
            'address_id.exists' => 'La dirección debe existir en la tabla de address.'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'msg' => "Error en la validación de datos.",
                'errors' => $validator->errors()
            ], 422);
        }
        
        $store = Store::find($id);
        
        if (!$store) {
            return response()->json([
                'result' => false,
                'msg' => "No se encontró la tienda especificada.",
            ], 404);
        }
        
        $store->update($request->only(['manager_staff_id', 'address_id']));
        
        return response()->json([
            'result' => true,
            'msg' => "Información de la tienda actualizada.",
            'data' => $store
            ], 200);

    }

    public function destroy($id)
    {
        $store = Store::find($id);
        
        if (!$store) {
            return response()->json([
                'result' => false,
                'msg' => "No se encontró la tienda especificada.",
            ], 404);
        }
        
        $store->delete();
        
        return response()->json([
            'result' => true,
            'msg' => "Tienda eliminada con éxito.",
        ], 200);    
    }
}
