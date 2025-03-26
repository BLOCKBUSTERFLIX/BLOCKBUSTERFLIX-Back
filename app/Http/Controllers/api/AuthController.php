<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'result' => false,
                'msg' => 'Credenciales incorrectas'
            ], 401);
        }

        return response()->json([
            'result' => true,
            'msg' => "Sesión generada correctamente",
            'data' => [
                'token' => $token
            ]
        ]);
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json([
            'result' => true,
            'msg' => 'Sesión cerrada correctamente'
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'result' => true,
            'msg' => "Sesión actualizada correctamente",
            'data' => [
                'token' => Auth::guard('api')->refresh()
            ]
        ]);
    }

    public function me()
    {
        return response()->json([
            'result' => true,
            'msg' => "Datos encontrados",
            'data' => Auth::guard('api')->user()
        ]);
    }
}
