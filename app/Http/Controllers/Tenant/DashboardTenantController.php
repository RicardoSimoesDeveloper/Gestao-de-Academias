<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use Inertia\Inertia;

class DashboardTenantController extends Controller
{
    public function index()
    {
        $totalAlunos = Aluno::count();
        $alunosAtivos = Aluno::where('status', 'ativo')->count();
        $alunosInativos = Aluno::where('status', 'inativo')->count();

        $novosAlunosMes = Aluno::where('created_at', '>=', now()->subDays(30))->count();

        $rotatividade = $totalAlunos > 0
            ? round(($alunosInativos / $totalAlunos) * 100, 1)
            : 0;

        return Inertia::render('Tenant/TenantDashboard', [
            'metrics' => [
                'totalAlunos' => $totalAlunos,
                'ativos' => $alunosAtivos,
                'inativos' => $alunosInativos,
                'novosMes' => $novosAlunosMes,
                'taxaRotatividade' => $rotatividade,
            ],
            // A função tenant() é fornecida pelo Stancl Tenancy
            'academiaNome' => tenant('nome'),
        ]);
    }
}
