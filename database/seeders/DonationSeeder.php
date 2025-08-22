<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Support\Carbon;

class DonationSeeder extends Seeder
{
    public function run(): void
    {
        // Usuário de teste (você já criou via tinker o usuário "teste@teste.com", lembra?)
        $user = User::where('email', 'teste@teste.com')->first();

        // Garante que existe
        if (!$user) {
            $user = User::create([
                'name' => 'Usuário Teste',
                'email' => 'teste@teste.com',
                'password' => bcrypt('senha123'),
            ]);
        }

        // Cria 10 doações aleatórias
        for ($i = 0; $i < 10; $i++) {
            Donation::create([
                'user_id'   => $user->id,
                'date'      => Carbon::now()->subDays(rand(1, 365)),
                'location'  => 'Posto de Coleta ' . rand(1, 5),
                'volume_ml' => rand(300, 500),
                'modality'  => collect(['whole_blood', 'platelets', 'plasma'])->random(),
                'notes'     => 'Doação feita em campanha especial',
            ]);
        }
    }
}
