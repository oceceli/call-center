<?php

use App\Http\Controllers\Auth\RegisteredUserController;
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

Route::group(['auth', 'verified'], function () {

    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    
    Route::get('/users', [RegisteredUserController::class, 'index'])->name('users');
    Route::post('/users', [RegisteredUserController::class, 'store'])->name('users.post');
    Route::patch('/users/{user}', [RegisteredUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [RegisteredUserController::class, 'destroy'])->name('users.destroy');
    
    Route::get('/customers', function() {
        return Inertia::render('Customers');
    })->name('customers');
    
    Route::get('/test', function() {
        return Inertia::render('test');
    });
    
});






