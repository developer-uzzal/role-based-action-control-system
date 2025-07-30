<?php

use App\Http\Controllers\Api\DashboardController;
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

    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/role-create', [RoleController::class, 'store']);
    Route::get('/role-show/{id}', [RoleController::class, 'show']);
    Route::put('/role-update/{id}', [RoleController::class, 'update']);
    Route::delete('/role-delete/{id}', [RoleController::class, 'destroy']);

    Route::middleware('api.permission:view-user')->get('/users', [UserController::class, 'index']);

    Route::middleware('api.permission:create-user')->post('/user', [UserController::class, 'store']);
    Route::middleware('api.permission:edit-user')->put('/users/{id}', [UserController::class, 'update']);
    Route::middleware('api.permission:delete-user')->delete('/users/{id}', [UserController::class, 'destroy']);
    Route::middleware('api.permission:view-user')->get('/dashboard', [DashboardController::class, 'index']);
    
});

