<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CentralDashboardController extends Controller
{
    public function index()
    {
        // Carrega todos os Tenants com a relação 'domains'
        $tenants = Tenant::with('domains')->get();

        $detalhes = [];

        foreach ($tenants as $tenant) {

            $alunos = 0;
            $faturamento = 0;
            $erro = false;

            // Pega o domínio principal (primeiro domínio no relacionamento)
            $dominioAcesso = $tenant->domains->first() ? $tenant->domains->first()->domain : 'N/A';
            
            // Verifica se a propriedade 'nome' existe no seu modelo Tenant. Se não, use 'name'.
            $nomeAcademia = $tenant->name ?? $tenant->nome;

            try {
                // Força entrar no banco do tenant
                tenancy()->initialize($tenant);

                // Conta os alunos desse tenant
                $alunos = DB::table('alunos')->count();

                // Soma dos planos ou mensalidades (Mantenha o faturamento em 0 se a coluna não existir)
                // Se você não tem 'valor_plano', esta lógica pode ser removida ou ajustada
                if (DB::getSchemaBuilder()->hasColumn('alunos', 'valor_plano')) {
                    $faturamento = DB::table('alunos')->sum('valor_plano');
                }
                // Se estiver usando Assinaturas/Planos, o faturamento deve ser ajustado para um cálculo mais real.

            } catch (\Throwable $e) {
                // Captura exceções (ex: DB não conectado, tabela não existe)
                $erro = true;
            }

            // Volta para DB central
            tenancy()->end();

            $detalhes[] = [
                'id' => $tenant->id,
                'nome' => $nomeAcademia, // Usando o campo NAME do Tenant
                'dominio' => $dominioAcesso, // Usando o domínio carregado
                'alunos' => $alunos,
                'faturamento' => $faturamento,
                'status_erro' => $erro,
            ];
        }

        // Resumo geral
        $totalAlunos = array_sum(array_column($detalhes, 'alunos'));
        $totalFaturamento = array_sum(array_column($detalhes, 'faturamento'));

        return Inertia::render('Central/Dashboard/CentralDashboard', [
            'resumo' => [
                'total_tenants' => $tenants->count(),
                'total_alunos' => $totalAlunos,
                'total_faturamento' => $totalFaturamento,
                // O Ticket Médio deve ser dividido pelo número de alunos, não de Tenants.
                'ticket_medio' => $totalAlunos > 0 
                    ? $totalFaturamento / $totalAlunos 
                    : 0,
            ],
            'detalhes' => $detalhes,
        ]);
    }
}