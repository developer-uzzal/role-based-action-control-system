<?php


use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;

Route::get('/', [UserController::class, 'loginPage'])->name('login');

Route::post('/login', [UserController::class, 'login']);



Route::middleware([AuthMiddleware::class])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/roles', [RoleController::class, 'index'])->name('rolePage');

    Route::get('/logout', [UserController::class, 'logout']);

    Route::middleware('check-permission:view-user')->get('/roles', [RoleController::class, 'index']);
    Route::middleware('check-permission:create-user')->post('/role-create', [RoleController::class, 'store']);
    Route::middleware('check-permission:view-user')->get('/role-show/{id}', [RoleController::class, 'show']);
    Route::middleware('check-permission:edit-user')->put('/role-update/{id}', [RoleController::class, 'update']);
    Route::middleware('check-permission:delete-user')->delete('/role-delete/{id}', [RoleController::class, 'destroy']);

    Route::middleware('check-permission:view-user')->get('/users', [UserController::class, 'index']);
    Route::middleware('check-permission:create-user')->post('/user', [UserController::class, 'store']);
    Route::middleware('check-permission:view-user')->get('/user/{id}', [UserController::class, 'show']);
    Route::middleware('check-permission:edit-user')->put('/user/{id}', [UserController::class, 'update']);
    Route::middleware('check-permission:delete-user')->delete('/user/{id}', [UserController::class, 'destroy']);
    // Route::middleware('check-permission:view-user')->get('/dashboard', [DashboardController::class, 'index']);

    // role assign permission
    Route::middleware('check-permission:edit-user')->post('/role-permission-assign', [PermissionController::class, 'assignPermission']);
    Route::middleware('check-permission:edit-user')->post('/role-user-assign', [PermissionController::class, 'assignUserPermission']);





    
});
