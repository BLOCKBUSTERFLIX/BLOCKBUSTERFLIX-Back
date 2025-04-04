<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\Activation;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = Staff::with('address', 'role')->get();
        if (count($staffs) <= 0) {
            return response()->json([
                'result' => false,
                'message' => 'No hay staff registrados.'
            ], 204);
        }

        $staffData = $staffs->map(function ($staff){
            return [
                'id' => $staff->id,
                'first_name' => $staff->first_name,
                'last_name' => $staff->last_name,
                'address_id' => $staff->address_id ? $staff->address->address : null,
                'picture' => $staff->picture,
                'email' => $staff->email,
                'username' => $staff->username,
                'role_id' => $staff->role_id ? $staff->role->role : null,
                'role' => $staff->role,
                'code_verification' => $staff->code_verification,
                'code_recuperation' => $staff->code_recuperation,
                'created_at' => $staff->created_at,
                'updated_at' => $staff->updated_at,
            ];
        });

        return response()->json([
            'result' => true,
            'message' => 'Staff encontrados.',
            'data' => $staffData
        ], 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'address_id' => 'required|exists:addresses,id',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'required|unique:staff,email|email|max:50',
            'store_id' => 'required|exists:stores,id',
            'username' => 'required|string|max:16|unique:staff,username',
            'password' => 'nullable|string|min:6|max:40',
            'role_id' => 'sometimes|exists:roles,id',
        ], [
            'first_name.required' => 'El nombre es obligatorio.',
            'first_name.string' => 'El nombre debe ser un texto.',
            'first_name.max' => 'El nombre no puede exceder los 45 caracteres.',

            'last_name.required' => 'El apellido es obligatorio.',
            'last_name.string' => 'El apellido debe ser un texto.',
            'last_name.max' => 'El apellido no puede exceder los 45 caracteres.',

            'address_id.required' => 'Se requiere una dirección.',
            'address_id.exists' => 'La dirección seleccionada no es válida.',

            'picture.image' => 'La imagen debe ser un archivo de imagen.',
            'picture.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg, gif o svg.',
            'picture.max' => 'La imagen no puede superar los 2MB.',

            'email.email' => 'El correo electrónico debe ser válido.',
            'email.max' => 'El correo electrónico no puede exceder los 50 caracteres.',

            'store_id.required' => 'Se requiere una tienda.',
            'store_id.exists' => 'La tienda seleccionada no es válida.',

            'active.boolean' => 'El estado de activo debe ser verdadero o falso.',

            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.string' => 'El nombre de usuario debe ser un texto.',
            'username.max' => 'El nombre de usuario no puede exceder los 16 caracteres.',
            'username.unique' => 'El nombre de usuario ya está en uso.',

            'password.string' => 'La contraseña debe ser un texto.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.max' => 'La contraseña no puede exceder los 40 caracteres.',

            'role_id.required' => 'Se requiere un rol.',
            'role_id.exists' => 'El rol seleccionada no es válido.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'msg' => "Los datos no cumplen.",
                'errors' => $validator->errors()
            ], 421);
        }
        Log::info($request);
        $staff = Staff::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'address_id' => $request->input('address_id'),
            'picture' => $request->input('picture'),
            'email' => $request->input('email'),
            'store_id' => $request->input('store_id'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'role_id' => $request->input('role_id'),
        ]);

/*         $signedUrl = URL::temporarySignedRoute(
            'activate.acount',
            now()->addHours(1),
            ['email' => $staff->email]
        );

        Mail::to($staff->email)->send(new Activation($signedUrl, $staff->first_name));
 */
        return response()->json([
            'result' => true,
            'msg' => "Staff registrado de manera exitosa."
        ], 200);
    }

    public function show($id)
    {
        $staff = Staff::with('address', 'role')->find($id);
        if (!$staff) {
            return response()->json([
                'result' => false,
                'message' => 'No se encontró el staff.'
            ], 204);
        }
        return response()->json([
            'result' => true,
            'message' => 'Staff encontrado.',
            'data' => $staff
        ], 200);
    }
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'address_id' => 'required|exists:addresses,id',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'nullable|email|max:50',
            'store_id' => 'required|exists:stores,id',
            'active' => 'nullable|boolean',
            'username' => 'required|string|max:16,username',
            'password' => 'nullable|string|min:6|max:40',
            'role_id' => 'required|exists:roles,id',
        ], [
            'first_name.required' => 'El nombre es obligatorio.',
            'first_name.string' => 'El nombre debe ser un texto.',
            'first_name.max' => 'El nombre no puede exceder los 45 caracteres.',

            'last_name.required' => 'El apellido es obligatorio.',
            'last_name.string' => 'El apellido debe ser un texto.',
            'last_name.max' => 'El apellido no puede exceder los 45 caracteres.',

            'address_id.required' => 'Se requiere una dirección.',
            'address_id.exists' => 'La dirección seleccionada no es válida.',

            'picture.image' => 'La imagen debe ser un archivo de imagen.',
            'picture.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg, gif o svg.',
            'picture.max' => 'La imagen no puede superar los 2MB.',

            'email.email' => 'El correo electrónico debe ser válido.',
            'email.max' => 'El correo electrónico no puede exceder los 50 caracteres.',

            'store_id.required' => 'Se requiere una tienda.',
            'store_id.exists' => 'La tienda seleccionada no es válida.',

            'active.boolean' => 'El estado de activo debe ser verdadero o falso.',

            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.string' => 'El nombre de usuario debe ser un texto.',
            'username.max' => 'El nombre de usuario no puede exceder los 16 caracteres.',
            'username.unique' => 'El nombre de usuario ya está en uso.',

            'password.string' => 'La contraseña debe ser un texto.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.max' => 'La contraseña no puede exceder los 40 caracteres.',

            'role_id.required' => 'Se requiere un rol.',
            'role_id.exists' => 'El rol seleccionada no es válido.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data_received' => $request->all(),
                'result' => false,
                'msg' => "Los datos no cumplen.",
                'errors' => $validator->errors()
            ], 421);
        }

        $staff = Staff::find($id);
        if (!$staff) {
            return response()->json([
                'result' => false,
                'message' => 'No se encontró el staff.'
            ], 204);
        }

        $staff->update($request->only('first_name', 'last_name', 'address_id', 'picture', 'email', 'store_id', 'active', 'username', 'password', 'role_id'));
        return response()->json([
            'result' => true,
            'msg' => "Se actualizaron los datos de manera exitosa.",
            'data' => $staff
        ], 200);
    }

    public function destroy($id)
    {
        $staff = Staff::find($id);
        if (!$staff) {
            return response()->json([
                'result' => false,
                'message' => 'No se encontró el staff.'
            ], 204);
        }
        $staff->delete();
        return response()->json([
            'result' => true,
            'message' => 'Staff eliminado.'
        ], 200);
    }
}
