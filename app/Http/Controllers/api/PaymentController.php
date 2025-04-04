<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::with('customer', 'staff', 'rental.film')->get();

        if($payments->isEmpty()){
            return response()->json([
                'result' => false,
                'msg' => "No hay pagos registrados."
            ], 204);
        }

        $paymentData = $payments->map(function ($payment){
            return [
                'id' => $payment->id,
                'customer_id' => $payment->customer_id ? $payment->customer->first_name : null,
                'staff_id' => $payment->staff_id ? $payment->staff->first_name : null,
                'rental_id' => $payment->rental_id,
                //'rental_id' => $payment->rental_id ? $payment->rental->film->title : null,
                'amount' => $payment->amount,
                'payment_date' => $payment->payment_date
            ];
        });

        return response()->json([
            'result' => true,
            'msg' => "Lista de pagos obtenida exitosamente.",
            'data' => $paymentData
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
            'customer_id' => 'required|exists:customers,id',
            'staff_id' => 'required|exists:staff,id',
            'rental_id' => 'nullable|exists:rentals,id',
            'amount' => 'required|numeric|min:0|max:999.99',
            'payment_date' => 'nullable|date',
        ], [
            'customer_id.required' => 'Se requiere un cliente.',
            'customer_id.exists' => 'El cliente seleccionado no es válido.',
            'staff_id.required' => 'Se requiere un empleado.',
            'staff_id.exists' => 'El empleado seleccionado no es válido.',
            'rental_id.exists' => 'El alquiler seleccionado no es válido.',
            'amount.required' => 'Se requiere un monto.',
            'amount.numeric' => 'El monto debe ser un número.',
            'amount.min' => 'El monto no puede ser negativo.',
            'amount.max' => 'El monto no puede superar 999.99.',
            'payment_date.date' => 'La fecha de pago debe ser una fecha válida.',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'msg' => "Los datos no cumplen.",
                'errors' => $validator->errors()
            ], 421);
        }

        $payment = Payment::create($request->only('customer_id', 'staff_id', 'rental_id','amount', 'payment_date'));
        return response()->json([
            'result' => true,
            'msg' => "Se registro el pago de manera exitosa."
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $payment = Payment::with(['customer', 'staff', 'rental'])->find($id);

        if(!$payment){
            return response()->json([
                'result' => false,
                'msg' => "Pago no encontrado."
            ], 204);
        }

        return response()->json([
            'result' => true,
            'msg' => "Se encontro la  información del pago.",
            'data' => $payment
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'staff_id' => 'required|exists:staff,id',
            'rental_id' => 'nullable|exists:rentals,id',
            'amount' => 'required|numeric|min:0|max:999.99',
            'payment_date' => 'nullable|date',
        ], [
            'customer_id.required' => 'Se requiere un cliente.',
            'customer_id.exists' => 'El cliente seleccionado no es válido.',

            'staff_id.required' => 'Se requiere un empleado.',
            'staff_id.exists' => 'El empleado seleccionado no es válido.',

            'rental_id.exists' => 'El alquiler seleccionado no es válido.',

            'amount.required' => 'Se requiere un monto.',
            'amount.numeric' => 'El monto debe ser un número.',
            'amount.min' => 'El monto no puede ser negativo.',
            'amount.max' => 'El monto no puede superar 999.99.',
            
            'payment_date.date' => 'La fecha de pago debe ser una fecha válida.',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'msg' => "Los datos no cumplen.",
                'errors' => $validator->errors()
            ], 421);
        }

        $payment = Payment::find($id);
        if(!$payment){
            return response()->json([
                'result' => false,
                'msg' => "Pago no encontrado."
            ], 204);
        }

        $payment->update($request->only('customer_id', 'staff_id', 'rental_id','amount', 'payment_date'));
        return response()->json([
            'result' => true,
            'msg' => "Se actualizo el pago de manera exitosa.",
            'data' => $payment
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $payment = Payment::find($id);
        if(!$payment){
            return response()->json([
                'result' => false,
                'msg' => "Pago no encontrado."
            ], 204);
        }

        $payment->delete();

        return response()->json([
            'result' => true,
            'msg' => "Se elimino el pago.",
        ], 200);
    }
}
