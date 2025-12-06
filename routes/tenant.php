<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Inertia\Inertia;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    
    Route::get('/', function () {
        // Isso renderiza o componente Vue localizado em resources/js/Pages/Tenant/Dashboard.vue
        return Inertia::render('Tenant/Dashboard', [
            // Podemos passar dados do tenant atual para o Vue
            'academia' => tenant('id'), 
            'plano' => tenant('plan') ?? 'Free'
        ]);
    });

});
