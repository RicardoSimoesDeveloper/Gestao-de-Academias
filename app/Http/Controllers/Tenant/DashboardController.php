<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Aluno; // Usaremos o Model de Aluno que já existe
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Coleta e exibe as métricas do Dashboard do Tenant.
     */
    public function index()
    {
        // 1. Coleta de Métricas (Dados do banco de dados do Tenant)
        $totalAlunos = Aluno::count();
        $alunosAtivos = Aluno::where('status', 'ativo')->count();
        $alunosInativos = Aluno::where('status', 'inativo')->count();
        
        // 2. Métrica de Cadastro Recente (últimos 30 dias)
        $novosAlunosMes = Aluno::where('created_at', '>=', now()->subDays(30))->count();

        // 3. Taxa de Rotatividade (Churn) - Exemplo Simples
        $rotatividade = $totalAlunos > 0 
            ? round(($alunosInativos / $totalAlunos) * 100, 1) 
            : 0;

        return Inertia::render('Tenant/Dashboard', [
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