<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    /**
     * REGISTRO
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email",
            "password" => "required|string|min:8|confirmed",
        ]);

        $user = User::create([
            "name" => $validated["name"],
            "email" => $validated["email"],
            "password" => Hash::make($validated["password"]),
            "rol" => "usuario", 
            "profile_photo" => null
        ]);

        $token = $user->createToken("mobile")->plainTextToken;

        return response()->json([
            "success" => true,
            "message" => "Usuario registrado exitosamente",
            "data" => [
                "user" => $user,
                "token" => $token
            ]
        ], 201);
    }

    /**
     * LOGIN
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "email" => "required|email",
            "password" => "required|string",
            "device_name" => "nullable|string",
        ]);

        $user = User::where("email", $validated["email"])->first();

        if (!$user || !Hash::check($validated["password"], $user->password)) {
            throw ValidationException::withMessages([
                "email" => ["Las credenciales son incorrectas."]
            ]);
        }

        // Revocar tokens previos del mismo dispositivo
        $user->tokens()->where("name", $validated["device_name"])->delete();

        $token = $user->createToken($validated["device_name"])->plainTextToken;

        return response()->json([
            "success" => true,
            "message" => "Login exitoso",
            "data" => [
                "user" => $user,
                "token" => $token
            ]
        ]);
    }

    /**
     * LOGOUT del token actual
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "success" => true,
            "message" => "Sesión cerrada"
        ]);
    }

    /**
     * LOGOUT de todos los dispositivos
     */
    public function logoutAll(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            "success" => true,
            "message" => "Sesiones cerradas en todos los dispositivos"
        ]);
    }

    /**
     * OBTENER PERFIL DEL USUARIO AUTENTICADO
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            "success" => true,
            "data" => $request->user()
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            "name" => "sometimes|required|string|max:255",
            "email" => "sometimes|required|email|unique:users,email," . $user->id,
            "password" => "sometimes|required|string|min:8|confirmed",
            "profile_photo" => "nullable|image|max:2048"
        ]);

        if (isset($validated["password"])) {
            $validated["password"] = Hash::make($validated["password"]);
        }

        if ($request->hasFile("profile_photo")) {
            $path = $request->file("profile_photo")->store("profile_photos", "public");
            $validated["profile_photo"] = $path;
        }

        $user->update($validated);

        return response()->json([
            "success" => true,
            "message" => "Perfil actualizado exitosamente",
            "data" => $user
        ]);
    }
}