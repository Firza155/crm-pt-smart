<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// Route untuk login & logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

// Semua route di dalam group ini wajib login
Route::middleware(['auth'])->group(function () {

    // Dashboard (bisa diakses semua role)
    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    // Sales Routes
    Route::middleware(['role:sales'])->group(function () {
        Route::get('/leads', [LeadController::class, 'index']);
        Route::get('/projects/create', [ProjectController::class, 'create']);
        Route::post('/projects', [ProjectController::class, 'store']);
    });

    // Manager Routes
     Route::middleware(['role:manager'])->group(function () {
        Route::get('/projects', [ProjectController::class, 'index']);
        Route::post('/projects/{id}/approve', [ProjectController::class, 'approve']);
        Route::post('/projects/{id}/reject', [ProjectController::class, 'reject']);
    });
});

/*
|--------------------------------------------------------------------------
| TEST ROLE MIDDLEWARE
|--------------------------------------------------------------------------
*/
Route::get('/test-role', function () {
    return 'ROLE OK';
})->middleware('role:sales');

/*
|--------------------------------------------------------------------------
| User Management (Internal)
|--------------------------------------------------------------------------
| Hanya manager yang boleh membuat user baru
*/
Route::post('/users', [UserController::class, 'store'])
    ->middleware(['auth', 'role:manager']);