<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\ApiCheckPermission;
use App\Http\Middleware\CheckPermission;
use App\Http\Middleware\HandleInertiaRequests;
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
        $middleware->web(append: [
                          HandleInertiaRequests::class,
                      ]);
        $middleware->alias(['api.permission' => ApiCheckPermission::class]);
        $middleware->alias(['check-permission' => CheckPermission::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
