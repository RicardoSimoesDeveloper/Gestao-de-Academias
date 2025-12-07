<?php

namespace Database\Seeders;

use App\Models\User; // Certifique-se de que o caminho do seu modelo User está correto
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CentralUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::where('email', 'admin@central.com')->exists()) {
            
            User::create([
                'name' => 'Administrador Central',
                'email' => 'admin@central.com',
                'password' => Hash::make('123456'),
            ]);

            $this->command->info('Usuário Central (admin@central.com) criado com sucesso!');
        } else {
            $this->command->info('Usuário Central já existe. Pulando a criação.');
        }
    }
}