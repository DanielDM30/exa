<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsuarioController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json(['message' => 'Usuario registrado correctamente', 'user' => $user], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            return response()->json(['message' => 'Inicio de sesión exitoso']);
        } else {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Sesión cerrada'], 200);
    }
}
