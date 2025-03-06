<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::all();
        if(count($staff) <= 0){
            return response()->json([
                'result' => false,
                'message' => 'No hay staff registrados.'
            ], 404);
        }
        return response()->json([
            'result' => true,
            'message' => 'Staff encontrados.',
            'data' => $staff
        ]);
    }

    public function store(Request $request)
    {
        
    }
    public function show($id)
    {
        $staff = Staff::find($id);
        if(!$staff){
            return response()->json([
                'result' => false,
                'message' => 'No se encontró el staff.'
            ], 404);
        }
        return response()->json([
            'result' => true,
            'message' => 'Staff encontrado.',
            'data' => $staff
        ]);
    }
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $staff = Staff::find($id);
        if(!$staff){
            return response()->json([
                'result' => false,
                'message' => 'No se encontró el staff.'
            ], 404);
        }
        $staff->delete();
        return response()->json([
            'result' => true,
            'message' => 'Staff eliminado.'
        ]);
    }
}
