<?php

use App\Http\Middleware\{EnsureCartIsNotEmpty, EnsureIsAdmin, EnsureOwnsOrder};
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\{Middleware, Exceptions};

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'ensureCartIsNotEmpty' => EnsureCartIsNotEmpty::class,
            'ensureOwnsOrder' => EnsureOwnsOrder::class,
            'ensureIsAdmin' => EnsureIsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
