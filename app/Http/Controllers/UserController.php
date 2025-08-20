<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // Retorna os dados do usuário autenticado
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    // Atualiza os dados do usuário autenticado
    public function update(Request $request)
    {
        $user = $request->user();
        $user->update($request->all());
        return response()->json($user);
    }
}