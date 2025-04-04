<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Obtiene la lista de todas las direcciones registradas.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $addresses = Address::with('city')->take(100)->get();

        if ($addresses->isEmpty()) {
            return response()->json([
                'result' => false,
                'msg' => "No hay direcciones registradas."
            ], 204);
        }

        $addressData = $addresses->map(function ($address){
            return [
                'id' => $address->id,
                'address' => $address->address,
                'address2' => $address->address2,
                'district' => $address->district,
                'city_id' => $address->city_id ? $address->city->city : null,
                'postal_code' => $address->postal_code,
                'phone' => $address->phone,
                'location' => $address->location
            ];
        });

        return response()->json([
            'result' => true,
            'msg' => "Lista de direcciones obtenida exitosamente.",
            'data' => $addressData
        ], 200);
    }

    /**
     * Registra una nueva dirección en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string|max:50',
            'address2' => 'nullable|string|max:50',
            'district' => 'required|string|max:20',
            'city_id' => 'required|integer|exists:cities,id',
            'postal_code' => 'nullable|string|max:10',
            'phone' => 'required|string|max:20',
            'location' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'msg' => "Error en la validación de datos.",
                'errors' => $validator->errors()
            ], 400);
        }

        $address = Address::create($request->only(['address', 'address2', 'district', 'city_id', 'postal_code', 'phone', 'location']));

        return response()->json([
            'result' => true,
            'msg' => "Dirección registrada con éxito.",
            'data' => $address
        ], 201);
    }

    /**
     * Muestra la información de una dirección específica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $address = Address::find($id);

        if (!$address) {
            return response()->json([
                'result' => false,
                'msg' => "No se encontró la dirección especificada.",
            ], 204);
        }

        return response()->json([
            'result' => true,
            'msg' => "Información de la dirección obtenida.",
            'data' => $address
        ], 200);
    }

    /**
     * Actualiza la información de una dirección existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string|max:50',
            'address2' => 'nullable|string|max:50',
            'district' => 'required|string|max:20',
            'city_id' => 'required|integer|exists:cities,id',
            'postal_code' => 'nullable|string|max:10',
            'phone' => 'required|string|max:20',
            'location' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'msg' => "Error en la validación de datos.",
                'errors' => $validator->errors()
            ], 400);
        }

        $address = Address::find($id);

        if (!$address) {
            return response()->json([
                'result' => false,
                'msg' => "No se encontró la dirección especificada.",
            ], 204);
        }

        $address->update($request->only(['address', 'address2', 'district', 'city_id', 'postal_code', 'phone', 'location']));

        return response()->json([
            'result' => true,
            'msg' => "Información de la dirección actualizada.",
            'data' => $address
        ], 200);
    }

    /**
     * Elimina una dirección de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $address = Address::find($id);

        if (!$address) {
            return response()->json([
                'result' => false,
                'msg' => "No se encontró la dirección especificada.",
            ], 404);
        }

        $address->delete();

        return response()->json([
            'result' => true,
            'msg' => "Dirección eliminada exitosamente."
        ], 200);
    }
}
