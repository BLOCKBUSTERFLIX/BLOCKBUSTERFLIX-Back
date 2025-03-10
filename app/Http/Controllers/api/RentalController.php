<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rentals = Rental::with('inventory', 'customer', 'staff')->get();

        if(!$rentals->isEmpty()){
            return response()->json([
                'result' => false,
                'msg' => "No hay rentas registradas."
            ], 404);
        }

        return response()->json([
            'result' => true,
            'msg' => "Lista de rentas obtenida exitosamente.",
            'data' => $rentals
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
            'rental_date' => 'required|date',
            'inventory_id' => 'required|exists:inventories,id',
            'customer_id' => 'required|exists:customers,id',
            'return_date' => 'nullable|date|after:rental_date',
            'staff_id' => 'required|exists:staff,id',
        ], [
            'rental_date.required' => 'Se requiere la fecha de alquiler.',
            'rental_date.date' => 'La fecha de alquiler debe ser una fecha válida.',

            'inventory_id.required' => 'Se requiere un inventario.',
            'inventory_id.exists' => 'El inventario seleccionado no es válido.',

            'customer_id.required' => 'Se requiere un cliente.',
            'customer_id.exists' => 'El cliente seleccionado no es válido.',

            'return_date.date' => 'La fecha de devolución debe ser una fecha válida.',
            'return_date.after' => 'La fecha de devolución debe ser posterior a la fecha de alquiler.',
            
            'staff_id.required' => 'Se requiere un empleado.',
            'staff_id.exists' => 'El empleado seleccionado no es válido.',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'msg' => "Los datos no cumplen.",
                'errors' => $validator->errors()
            ], 421);
        }

        $rental = Rental::create($request->only('rental_date', 'inventory_id', 'customer_id','return_date', 'staff_id'));
        return response()->json([
            'result' => true,
            'msg' => "Renta registrada de manera exitosa."
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $rental = Rental::with(['inventory', 'customer', 'staff'])->find($id);

        if(!$rental){
            return response()->json([
                'result' => false,
                'msg' => "Renta no encontrado."
            ]);
        }

        return response()->json([
            'result' => true,
            'msg' => "Información encontrada.",
            'data' => $rental
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'rental_date' => 'required|date',
            'inventory_id' => 'required|exists:inventories,id',
            'customer_id' => 'required|exists:customers,id',
            'return_date' => 'nullable|date|after:rental_date',
            'staff_id' => 'required|exists:staff,id',
        ], [
            'rental_date.required' => 'Se requiere la fecha de alquiler.',
            'rental_date.date' => 'La fecha de alquiler debe ser una fecha válida.',

            'inventory_id.required' => 'Se requiere un inventario.',
            'inventory_id.exists' => 'El inventario seleccionado no es válido.',

            'customer_id.required' => 'Se requiere un cliente.',
            'customer_id.exists' => 'El cliente seleccionado no es válido.',

            'return_date.date' => 'La fecha de devolución debe ser una fecha válida.',
            'return_date.after' => 'La fecha de devolución debe ser posterior a la fecha de alquiler.',

            'staff_id.required' => 'Se requiere un empleado.',
            'staff_id.exists' => 'El empleado seleccionado no es válido.',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'msg' => "Los datos no cumplen.",
                'errors' => $validator->errors()
            ], 421);
        }

        $rental = Rental::find($id);
        if(!$rental){
            return response()->json([
                'result' => false,
                'msg' => "Renta no encontrado."
            ]);
        }

        $rental->update($request->only('rental_date', 'inventory_id', 'customer_id','return_date', 'staff_id'));
        return response()->json([
            'result' => true,
            'msg' => "Se actualizaron los datos de manera exitosa.",
            'data' => $rental
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $rental = Rental::find($id);
        if(!$rental){
            return response()->json([
                'result' => false,
                'msg' => "Registro no encontrado."
            ]);
        }

        $rental->delete();
        
        return response()->json([
            'result' => true,
            'msg' => "Se elimino el registro especificado.",
        ]);
    }
}
