<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Importa nossos controllers (garanta que esses arquivos existem em app/Http/Controllers)
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DonationController;

/**
 * Rotas públicas de autenticação (sem token).
 * /api/auth/register  → cria usuário e retorna token
 * /api/auth/login     → retorna token p/ usuário existente
 */
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);
});

/**
 * Rotas protegidas por token (Sanctum).
 * Para acessar, envie no header: Authorization: Bearer {token}
 * Obs.: o prefixo /api é aplicado automaticamente a tudo que está em routes/api.php
 */
Route::middleware('auth:sanctum')->group(function () {
    // Perfil do usuário autenticado
    Route::get('users/me',   [UserController::class, 'me']);     // GET /api/users/me
    Route::patch('users/me', [UserController::class, 'update']); // PATCH /api/users/me

    // CRUD mínimo de Doações (sempre do usuário logado)
    Route::get('donations',         [DonationController::class, 'index']);   // GET /api/donations
    Route::post('donations',        [DonationController::class, 'store']);   // POST /api/donations
    Route::get('donations/{id}',    [DonationController::class, 'show']);    // GET /api/donations/123
    Route::delete('donations/{id}', [DonationController::class, 'destroy']); // DELETE /api/donations/123
});

Route::post('debug/echo', function (Request $req) {
    return response()->json([
        'content_type' => $req->header('Content-Type'),
        'all'          => $req->all(),        // o que o Laravel parseou
        'raw'          => $req->getContent(), // corpo bruto recebido
    ]);
});