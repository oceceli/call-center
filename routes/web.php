<?php

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



Route::get('/', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';


Route::get('/users', function() {
    return Inertia::render('Users', [
        'users' => cache()->rememberForever('users', function() {
            return User::all();
        })
    ]);
})->name('users');


Route::get('/customers', function() {
    return Inertia::render('Customers');
})->name('customers');




Route::get('/test', function() {
    return Inertia::render('test');
});