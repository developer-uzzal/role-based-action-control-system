<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/login', function () { 
    return response()->json(['message' => 'Unauthorized']);
 })->name('login');

Route::post('/login', [UserController::class, 'login']);



Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/logout', [UserController::class, 'logout']);

    Route::middleware('api.permission:view-user')->get('/roles', [RoleController::class, 'index']);
    Route::middleware('api.permission:create-user')->post('/role-create', [RoleController::class, 'store']);
    Route::middleware('api.permission:view-user')->get('/role-show/{id}', [RoleController::class, 'show']);
    Route::middleware('api.permission:edit-user')->put('/role-update/{id}', [RoleController::class, 'update']);
    Route::middleware('api.permission:delete-user')->delete('/role-delete/{id}', [RoleController::class, 'destroy']);

    Route::middleware('api.permission:view-user')->get('/users', [UserController::class, 'index']);
    Route::middleware('api.permission:create-user')->post('/user', [UserController::class, 'store']);
    Route::middleware('api.permission:view-user')->get('/user/{id}', [UserController::class, 'show']);
    Route::middleware('api.permission:edit-user')->put('/user/{id}', [UserController::class, 'update']);
    Route::middleware('api.permission:delete-user')->delete('/user/{id}', [UserController::class, 'destroy']);
    Route::middleware('api.permission:view-user')->get('/dashboard', [DashboardController::class, 'index']);

    // role assign permission
    Route::middleware('api.permission:edit-user')->post('/role-permission-assign', [PermissionController::class, 'assignPermission']);





    
});

