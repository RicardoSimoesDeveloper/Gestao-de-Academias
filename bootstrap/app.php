<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ATENÇÃO: Se tiver algo como 'InitializeTenancyByDomain' aqui dentro, APAGUE!
        // O Tenancy não pode estar no middleware global.
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();