<?php

namespace App\Models;
// Modelo do usuário autenticável do Laravel
// use Illuminate\Cont\racts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// Trait do Sanctum para emitir/validar tokens de API
use Laravel\Sanctum\HasApiTokens; 

class User extends Authenticatable
{
   /**
     * Traits usadas:
     * - HasApiTokens: adiciona métodos p/ criar tokens (Sanctum)
     * - HasFactory: permite usar factories em testes/seeders
     * - Notifiable: habilita notificações (e-mail, etc.)
     */
    use HasFactory, Notifiable, HasApiTokens;
    
     /**
     * Campos permitidos para atribuição em massa (mass assignment).
     * Evita erro de MassAssignmentException quando usamos User::create([...]).
     */
    
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Campos que devem ser ocultados em arrays/JSON.
     * Útil para não expor dados sensíveis como senha e token de sessão.
     */

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversões (casts) de atributos:
     * - email_verified_at: vira instancia de DateTime automaticamente
     * - password: 'hashed' => Eloquent faz Hash::make automaticamente ao salvar
     */

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',  // NÃO faça Hash::make manualmente no controller
        ];
    }
}
