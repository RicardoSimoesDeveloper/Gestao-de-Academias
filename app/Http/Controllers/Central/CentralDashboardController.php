<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CentralDashboardController extends Controller
{
    /**
     * Dashboard Central
     */
    public function index()
    {
        // Total de academias
        $totalTenants = Tenant::count();

        // Novas no mês
        $newTenantsThisMonth = Tenant::where('created_at', '>=', now()->startOfMonth())->count();

        // Total de alunos nos tenants
        $totalAlunos = 0;

        foreach (Tenant::all() as $tenant) {
            try {
                tenancy()->initialize($tenant);

                if (DB::getSchemaBuilder()->hasTable('alunos')) {
                    $totalAlunos += DB::table('alunos')->count();
                }
            } catch (\Throwable $e) {
                // ignora erros (tenant sem banco ou sem tabela)
            } finally {
                tenancy()->end();
            }
        }

        return Inertia::render('Central/Dashboard/CentralDashboard', [
            'totalTenants' => $totalTenants,
            'newTenantsThisMonth' => $newTenantsThisMonth,
            'totalAlunos' => $totalAlunos,
            'activePlansPercent' => '100%', // placeholder
        ]);
    }
}
