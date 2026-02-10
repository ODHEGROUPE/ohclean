<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminOrAgentMiddleware;
use App\Http\Middleware\AdminOnlyMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin.or.agent' => AdminOrAgentMiddleware::class,
            'admin.only' => AdminOnlyMiddleware::class,
        ]);
        
        // Exclure certaines routes de la vérification CSRF
        $middleware->validateCsrfTokens(except: [
            'commander', // Route de création de commande après paiement KKiaPay
            'webhook/*', // Webhooks
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
