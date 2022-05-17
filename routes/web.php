<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CallController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RoleController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;




// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });




require __DIR__.'/auth.php';


Route::middleware(['auth', 'verified'])->group(function() {

    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    
    Route::get('/users', [RegisteredUserController::class, 'index'])->name('users');
    Route::get('/users_list', [RegisteredUserController::class, 'usersList'])->name('users_list');
    Route::post('/users', [RegisteredUserController::class, 'store'])->name('users.post');
    Route::patch('/users/{user}', [RegisteredUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [RegisteredUserController::class, 'destroy'])->name('users.destroy');
    
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.post');
    Route::patch('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    
    Route::post('/customers_import', [CustomerController::class, 'import'])->name('customers_import');
    Route::post('/customers_export', [CustomerController::class, 'export'])->name('customers_export');
    Route::post('/customers_assign/{user}', [CustomerController::class, 'customersAssign'])->name('customers_assign');

    Route::post('/call/{customer}', [CallController::class, 'store'])->name('call.post');
    Route::patch('/call/{call}', [CallController::class, 'update'])->name('call.update');
    Route::delete('/call/{call}', [CallController::class, 'destroy'])->name('call.destroy');
    
    Route::get('/roles', [RoleController::class, 'index'])->name('roles');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.post');
    Route::patch('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::get('/roles/available_perms', [RoleController::class, 'availablePerms'])->name('available_perms');
    Route::get('/roles/available_roles', [RoleController::class, 'availableRoles'])->name('available_roles');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    Route::get('/test', function() {
        return Inertia::render('test');
    });
    
});






