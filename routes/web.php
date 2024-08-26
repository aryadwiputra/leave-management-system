<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('pages.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', function () {
        return view('pages.dashboard');
    })->name('index');

    Route::resource('departments', DepartmentController::class);
    Route::get('departments/get', [DepartmentController::class, 'getData'])->name('departments.get');
    // Route::post('departments/sync-positions', [DepartmentController::class, 'syncPositions'])->name('departments.syncPositions');

    Route::resource('positions', PositionController::class);
    Route::get('positions/get', [PositionController::class, 'getData'])->name('positions.get');

    Route::resource('users', UsersController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
