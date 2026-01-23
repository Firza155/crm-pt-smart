<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Models\Lead;
use Illuminate\Support\Facades\Auth;


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
        Route::post('/leads', [LeadController::class, 'store']);
        Route::get('/leads/{lead}', [LeadController::class, 'show']);
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

/*
|--------------------------------------------------------------------------
| Sales UI Routes (Blade Views)
|--------------------------------------------------------------------------
| Khusus tampilan frontend (tanpa controller)
*/
Route::middleware(['auth', 'role:sales'])
    ->prefix('sales')
    ->group(function () {

        Route::get('/dashboard', fn () => view('sales.dashboard'));
        Route::get('/leads/create', fn () => view('sales.leads.create'));

        Route::get('/projects/create/{lead}', function ($lead) {
            return view('sales.projects.create', [
                'leadId' => $lead
            ]);
        });

        Route::get('/leads', function () {
            $leads = Lead::where('created_by', Auth::id())
                ->latest()
                ->get();

            return view('sales.leads.index', compact('leads'));
        });

        Route::get('/leads/{lead}/edit', function (Lead $lead) {
            if ($lead->created_by !== Auth::id()) {
                abort(403);
            }

            return view('sales.leads.edit', compact('lead'));
        });

         Route::get('/products', function () {
            $products = \App\Models\Product::orderBy('speed')->get();
            return view('sales.products.index', compact('products'));
        });
    });

/*
|--------------------------------------------------------------------------
| MANAGER - UI ROUTES (Blade Views)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:manager'])
    ->prefix('manager')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('manager.dashboard', [
                'pendingCount'  => \App\Models\Project::where('status', 'pending')->count(),
                'approvedCount' => \App\Models\Project::where('status', 'approved')->count(),
                'rejectedCount' => \App\Models\Project::where('status', 'rejected')->count(),
            ]);
        });

        Route::get('/projects/history', function () {
            $approved = \App\Models\Project::with(['lead', 'product'])
                ->where('status', 'approved')
                ->latest()
                ->get();

            $rejected = \App\Models\Project::with(['lead', 'product'])
                ->where('status', 'rejected')
                ->latest()
                ->get();

            return view('manager.projects.history', compact('approved', 'rejected'));
        });

        Route::get('/projects', fn () => view('manager.projects.index'));
        Route::get('/users/create', fn () => view('manager.users.create'));
        Route::post('/users', [UserController::class, 'store']);
    });
