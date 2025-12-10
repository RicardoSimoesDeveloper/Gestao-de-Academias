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
                tenancy()->initialize($tenant);

                $alunos = DB::table('alunos')->count();

                // Soma dos planos ou mensalidades (Mantenha o faturamento em 0 se a coluna não existir)
                if (DB::getSchemaBuilder()->hasColumn('alunos', 'valor_plano')) {
                    $faturamento = DB::table('alunos')->sum('valor_plano');
                }

            } catch (\Throwable $e) {
                $erro = true;
            }

            tenancy()->end();

            $detalhes[] = [
                'id' => $tenant->id,
                'nome' => $nomeAcademia,
                'dominio' => $dominioAcesso,
                'alunos' => $alunos,
                'faturamento' => $faturamento,
                'status_erro' => $erro,
            ];
        }

        $totalAlunos = array_sum(array_column($detalhes, 'alunos'));
        $totalFaturamento = array_sum(array_column($detalhes, 'faturamento'));

        return Inertia::render('Central/Dashboard/CentralDashboard', [
            'resumo' => [
                'total_tenants' => $tenants->count(),
                'total_alunos' => $totalAlunos,
                'total_faturamento' => $totalFaturamento,
                'ticket_medio' => $totalAlunos > 0
                    ? $totalFaturamento / $totalAlunos
                    : 0,
            ],
            'detalhes' => $detalhes,
        ]);
    }
}
