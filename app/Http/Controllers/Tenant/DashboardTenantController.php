<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

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

        // ---------------------------------------
        // 📊 NOVOS ALUNOS POR MÊS (últimos 6 meses)
        // ---------------------------------------
        $alunosPorMes = Aluno::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as mes"),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return Inertia::render('Tenant/TenantDashboard', [
            'metrics' => [
                'totalAlunos' => $totalAlunos,
                'ativos' => $alunosAtivos,
                'inativos' => $alunosInativos,
                'novosMes' => $novosAlunosMes,
                'taxaRotatividade' => $rotatividade,
            ],
            'academiaNome' => tenant('nome'),
            'graficoAlunos' => $alunosPorMes, // <- enviado ao frontend
        ]);
    }
}
