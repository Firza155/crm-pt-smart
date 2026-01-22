<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
| Login & logout untuk user internal (Sales & Manager)
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes (Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Sales Routes
    |--------------------------------------------------------------------------
    | Akses khusus role sales
    */
    Route::middleware(['role:sales'])->group(function () {

        // Dashboard Sales
        Route::get('/sales/dashboard', function () {
            return view('sales.dashboard');
        });

        // Lead management
        Route::get('/leads', [LeadController::class, 'index']);
        Route::get('/leads/create', [LeadController::class, 'create']);
        Route::post('/leads', [LeadController::class, 'store']);
        Route::get('/leads/{lead}', [LeadController::class, 'show']);
        Route::get('/leads/{lead}/edit', [LeadController::class, 'edit']);
        Route::put('/leads/{lead}', [LeadController::class, 'update']);
        Route::delete('/leads/{lead}', [LeadController::class, 'destroy']);

        // Project submission
        Route::get('/projects/create/{lead}', [ProjectController::class, 'create']);
        Route::post('/projects', [ProjectController::class, 'store']);
    });

    /*
    |--------------------------------------------------------------------------
    | Manager Routes
    |--------------------------------------------------------------------------
    | Akses khusus role manager
    */
    Route::middleware(['role:manager'])->group(function () {

        // Dashboard Manager
        Route::get('/manager/dashboard', function () {
            return view('manager.dashboard');
        });

        // Project approval
        Route::get('/projects', [ProjectController::class, 'index']);
        Route::post('/projects/{project}/approve', [ProjectController::class, 'approve']);
        Route::post('/projects/{project}/reject', [ProjectController::class, 'reject']);

        // User management (internal)
        Route::post('/users', [UserController::class, 'store']);
    });
});