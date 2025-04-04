<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\Recovery;
use App\Mail\VerificationCode;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

        $user = Staff::find(Auth::guard('api')->id());

        if (!$user) {
            return response()->json([
                'result' => false,
                'msg' => 'Usuario no encontrado'
            ], 204);
        }

        $twoFactorCode = Str::random(6);
        $encryptedCode = Crypt::encryptString($twoFactorCode);

        $user->update([
            'code_verification' => $encryptedCode,
        ]);

        Mail::to($user->email)->send(new VerificationCode($twoFactorCode));

        return response()->json([
            'result' => true,
            'msg' => "Código de verificación enviado al correo",
            'data' => [
                'verification' => "twoFactor",
                'email' => $user->email
            ]
        ]);
    }

    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:staff,email',
            'code' => 'required|string|size:6',
        ]);

        $user = Staff::where('email', $request->email)->first();

        if (!$user || Crypt::decryptString($user->code_verification) !== $request->code) {
            return response()->json([
                'result' => false,
                'msg' => 'Código expirado o no válido.'
            ], 204);
        }

        $user->update([
            'code_verification' => null,
        ]);

        $username = $user->username;
        $customClaims = ['role_id' => $user->role_id];
        $token = JWTAuth::claims($customClaims)->fromUser($user);

        return response()->json([
            'result' => true,
            'msg' => "Autenticación exitosa",
            'data' => [
                'token' => $token,
                'username' => $username
            ]
        ]);
    }

    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:staff,email',
        ]);

        $user = Staff::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'result' => false,
                'msg' => 'Usuario no encontrado'
            ], 204);
        }

        $resetCode = Str::random(6);
        $encryptedCode = Crypt::encryptString($resetCode);

        $user->update([
            'code_recuperation' => $encryptedCode,
        ]);

        Mail::to($user->email)->send(new Recovery($resetCode));

        return response()->json([
            'result' => true,
            'msg' => "Código de recuperación enviado al correo",
            'data' => [
                'email' => $user->email
            ]
        ]);
    }

    public function verifyResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:staff,email',
            'code' => 'required|string|size:6',
        ]);
        
        $user = Staff::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'result' => false,
                'msg' => 'Usuario no encontrado'
            ], 204);
        }

        if (!$user || Crypt::decryptString($user->code_recuperation) !== $request->code) {
            return response()->json([
                'result' => false,
                'msg' => 'Código incorrecto o expirado.'
            ], 401);
        }

        return response()->json([
            'result' => true,
            'msg' => "Código validado.",
            'data' => [
                'email' => $user->email,
                'validate_code' => true,
            ]
        ]);

    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'validate_code' => 'required',
            'email' => 'required|email|exists:staff,email',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Staff::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'result' => false,
                'msg' => 'Usuario no encontrado'
            ], 204);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
            'code_recuperation' => null,
        ]);

        return response()->json([
            'result' => true,
            'msg' => "Contraseña actualizada correctamente"
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
