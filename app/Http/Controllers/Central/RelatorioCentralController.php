<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Inertia\Inertia;

class RelatorioCentralController extends Controller
{
    public function index()
    {
        $tenants = Tenant::with('domains')->get();

        $totalAlunos = 0;
        $totalFaturamento = 0;
        $dadosPorUnidade = [];

        foreach ($tenants as $tenant) {

            // BLINDAGEM: Tenta conectar. Se o banco não existir, captura o erro.
            try {
                tenancy()->initialize($tenant);
            } catch (\Stancl\Tenancy\Exceptions\TenantDatabaseDoesNotExistException $e) {
                // Se der erro, adiciona na lista como "Erro" e pula para o próximo
                $dadosPorUnidade[] = [
                    'id' => $tenant->id,
                    'nome' => $tenant->name.' (Banco de Dados Ausente)',
                    'dominio' => $tenant->domains->first()->domain ?? '-',
                    'alunos' => 0,
                    'faturamento' => 0,
                    'status_erro' => true, // Marca para pintar de vermelho no front
                ];

                continue; // Pula para a próxima iteração do foreach
            }

            // --- Se chegou aqui, o banco existe ---

            try {
                $qtdAlunos = \Illuminate\Support\Facades\DB::table('alunos')->count();
            } catch (\Exception $e) {
                $qtdAlunos = 0;
            }

            $faturamentoEstimado = $qtdAlunos * 90;

            $totalAlunos += $qtdAlunos;
            $totalFaturamento += $faturamentoEstimado;

            $dadosPorUnidade[] = [
                'id' => $tenant->id,
                'nome' => $tenant->name,
                'dominio' => $tenant->domains->first()->domain ?? '-',
                'alunos' => $qtdAlunos,
                'faturamento' => $faturamentoEstimado,
                'status_erro' => false,
            ];

            // Sai do tenant para voltar à central
            tenancy()->end();
        }

        return Inertia::render('Central/Relatorios/Index', [
            'resumo' => [
                'total_tenants' => $tenants->count(),
                'total_alunos' => $totalAlunos,
                'total_faturamento' => $totalFaturamento,
                'ticket_medio' => $totalAlunos > 0 ? ($totalFaturamento / $totalAlunos) : 0,
            ],
            'detalhes' => $dadosPorUnidade,
        ]);
    }
}
