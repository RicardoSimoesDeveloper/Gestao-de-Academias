<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appDomain = env('APP_DOMAIN', 'localhost');

        // Tenant 1
        $this->createTenant(
            id: 'academia1',
            name: 'Academia Sportfit',
            email_admin: 'admin1@academia1.com',
            senha_admin: '123456',
            appDomain: $appDomain
        );

        // Tenant 2
        $this->createTenant(
            id: 'academia2',
            name: 'Academia Powerfit',
            email_admin: 'admin2@academia2.com',
            senha_admin: '123456',
            appDomain: $appDomain
        );
    }

    private function createTenant(string $id, string $name, string $email_admin, string $senha_admin, string $appDomain): void
    {
        $domain = "{$id}.{$appDomain}";

        // Cria tenant no banco central
        $tenant = Tenant::create([
            'id' => $id,
            'name' => $name,
            'plano' => 'premium',
            'status' => 'ativo',
        ]);

        // Domínio
        $tenant->domains()->create([
            'domain' => $domain,
        ]);

        // Executa dentro do DB do tenant
        $tenant->run(function () use ($email_admin, $senha_admin) {

            User::create([
                'name' => 'Administrador Tenant',
                'email' => $email_admin,
                'password' => $senha_admin,
            ]);
        });

        $this->command->info("Tenant '{$name}' criado com domínio {$domain}");
    }
}
