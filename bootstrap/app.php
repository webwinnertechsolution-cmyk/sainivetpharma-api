<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // ✅ Existing middleware
        $middleware->web(append: [
            \App\Http\Middleware\InjectPageSeo::class,
        ]);
        
        // ✅ Custom CORS middleware already applied in routes/api.php
        // No need to add here
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();