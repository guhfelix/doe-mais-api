<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // usado só no login
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * POST /api/auth/register
     * - Valida inputs
     * - Cria o usuário (o Model aplica hash por causa do cast 'hashed')
     * - Gera token Sanctum e retorna JSON { token: "..." } com status 201
     */
    public function register(Request $request)
    {
        // 1) Validar entrada
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        // 2) Criar usuário
        // Atenção: NÃO usar Hash::make aqui por causa do cast 'hashed' no User
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
        ]);

        // 3) Gerar token
        $token = $user->createToken('api')->plainTextToken;

        // 4) Retornar JSON com status 201 (Created)
        return response()->json(['token' => $token], 201);
    }

    /**
     * POST /api/auth/login
     * - Valida e-mail/senha
     * - Compara a senha com Hash::check
     * - Gera token Sanctum e retorna JSON { token: "..." }
     */
    public function login(Request $request)
    {
        // 1) Validar entrada
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // 2) Buscar usuário
        $user = User::where('email', $data['email'])->first();

        // 3) Verificar senha
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciais inválidas.'],
            ]);
        }

        // 4) Token
        $token = $user->createToken('api')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
