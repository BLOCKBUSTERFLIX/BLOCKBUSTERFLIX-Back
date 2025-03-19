<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Mostrar lista de clientes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::with('store', 'address')->get();

        if($customers->isEmpty()){
            return response()->json([
                'result' => false,
                'msg' => "No hay clientes registrados."
            ], 404);
        }
        
        return response()->json([
            'result' => true,
            'msg' => "Lista de clientes obtenida exitosamente.",
            'data' => $customers
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
            'store_id' => 'required|exists:stores,id',
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'email' => 'nullable|email|max:50',
            'address_id' => 'required|exists:addresses,id',
            'active' => 'boolean',
        ], [
            'store_id.required' => 'Se requiere una tienda.',
            'store_id.exists' => 'La tienda seleccionada no es válida.',
            'first_name.required' => 'Se requiere un nombre.',
            'first_name.string' => 'El nombre debe ser un texto.',
            'first_name.max' => 'El nombre no debe superar los 45 caracteres.',
            'last_name.required' => 'Se requiere un apellido.',
            'last_name.string' => 'El apellido debe ser un texto.',
            'last_name.max' => 'El apellido no debe superar los 45 caracteres.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'email.max' => 'El correo electrónico no debe superar los 50 caracteres.',
            'address_id.required' => 'Se requiere una dirección.',
            'address_id.exists' => 'La dirección seleccionada no es válida.',
            'active.boolean' => 'El estado debe ser activo o inactivo.',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'msg' => "Los datos no cumplen.",
                'errors' => $validator->errors()
            ], 421);
        }

        $customer = Customer::create($request->only('store_id', 'first_name', 'last_name','email', 'address_id', 'active'));
        return response()->json([
            'result' => true,
            'msg' => "Se registro al cliente " . $customer->first_name . " de manera exitosa."
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $customer = Customer::with(['store', 'address'])->find($id);

        if(!$customer){
            return response()->json([
                'result' => false,
                'msg' => "Cliente no encontrado."
            ]);
        }

        return response()->json([
            'result' => true,
            'msg' => "Se encontro al cliente " . $customer->first_name . ".",
            'data' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'store_id' => 'required|exists:stores,id',
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'email' => 'nullable|email|max:50',
            'address_id' => 'required|exists:addresses,id',
            'active' => 'boolean',
        ], [
            'store_id.required' => 'Se requiere una tienda.',
            'store_id.exists' => 'La tienda seleccionada no es válida.',

            'first_name.required' => 'Se requiere un nombre.',
            'first_name.string' => 'El nombre debe ser un texto.',
            'first_name.max' => 'El nombre no debe superar los 45 caracteres.',

            'last_name.required' => 'Se requiere un apellido.',
            'last_name.string' => 'El apellido debe ser un texto.',
            'last_name.max' => 'El apellido no debe superar los 45 caracteres.',

            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'email.max' => 'El correo electrónico no debe superar los 50 caracteres.',

            'address_id.required' => 'Se requiere una dirección.',
            'address_id.exists' => 'La dirección seleccionada no es válida.',
            
            'active.boolean' => 'El estado debe ser activo o inactivo.',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'msg' => "Los datos no cumplen.",
                'errors' => $validator->errors()
            ], 421);
        }

        $customer = Customer::find($id);
        if(!$customer){
            return response()->json([
                'result' => false,
                'msg' => "Cliente no encontrado."
            ]);
        }

        $customer->update($request->only('store_id', 'first_name', 'last_name','email', 'address_id', 'active'));
        return response()->json([
            'result' => true,
            'msg' => "Se actualizaron los datos del cliente " . $customer->first_name . " de manera exitosa.",
            'data' => $customer
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $customer = Customer::find($id);
        if(!$customer){
            return response()->json([
                'result' => false,
                'msg' => "Cliente no encontrado."
            ]);
        }

        $customer->delete();

        return response()->json([
            'result' => true,
            'msg' => "Se elimino el cliente " . $customer->first_name . ".",
        ]);
    }
}
