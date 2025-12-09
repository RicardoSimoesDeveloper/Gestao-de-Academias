<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Tenant; // Certifique-se de que este é o caminho correto!
use App\Models\User; // O Model User do Tenant
use Illuminate\Support\Facades\DB; // Não mais necessário, mas mantido

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define o domínio base a partir da variável de ambiente (ou use um padrão para testes)
        $appDomain = env('APP_DOMAIN', 'localhost'); // Usando 'localhost' como fallback

        // --- 1. PROVISIONAMENTO: ACADEMIA 1 ---
        $this->createTenant(
            id: 'academia1',
            nome: 'Academia Sportfit',
            email_admin: 'admin1@academia1.com',
            senha_admin: '123456', // Mude em produção!
            appDomain: $appDomain
        );

        // --- 2. PROVISIONAMENTO: ACADEMIA 2 ---
        $this->createTenant(
            id: 'academia2',
            nome: 'Academia Powerfit',
            email_admin: 'admin2@academia2.com',
            senha_admin: '123456', // Mude em produção!
            appDomain: $appDomain
        );
    }

    /**
     * Função auxiliar para encapsular a lógica de criação do Tenant e seus recursos.
     */
    private function createTenant(string $id, string $nome, string $email_admin, string $senha_admin, string $appDomain): void
    {
        $subdomain = $id; 
        $domain = $subdomain . '.' . $appDomain;

        // 3. Criação do Tenant (no banco central)
        // Isso dispara a criação e migração do banco de dados do tenant automaticamente.
        $tenant = Tenant::create([
            'id' => $subdomain,
            'nome' => $nome,
            'plano' => 'premium', // Exemplo de um campo customizado
            'status' => 'ativo', // Exemplo de um campo customizado
        ]);

        // 4. Vincular o Domínio ao Tenant
        $tenant->domains()->create([
            'domain' => $domain,
        ]);

        // 5. Configuração do Tenant (Migrations e Usuário Admin)
        // O método 'run' muda o contexto da conexão para o banco de dados do tenant
        $tenant->run(function () use ($email_admin, $senha_admin) {
            // Cria um usuário no banco de dados específico 'tenancy_academiaX'
            User::create([
                'name' => 'Administrador Tenant',
                'email' => $email_admin,
                'password' => Hash::make($senha_admin),
            ]);
            
            $this->command->info("Usuário Admin criado para o Tenant: {$email_admin}");
        });

        $this->command->info("Tenant '{$nome}' e domínio '{$domain}' provisionados com sucesso!");
    }
}