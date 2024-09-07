<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserLeaveController;
use App\Http\Controllers\UsersController;
use App\Models\Leave;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('pages.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', function () {
        $izin_pending = Leave::where('status', 'pending')->where('type', 'izin')->count();
        $sakit_pending = Leave::where('status', 'pending')->where('type', 'sakit')->count();
        $lembur_pending = Leave::where('status', 'pending')->where('type', 'lembur')->count();
        $cuti_pending = Leave::where('status', 'pending')->where('type', 'cuti')->count();
        return view('pages.dashboard', compact('izin_pending', 'sakit_pending', 'lembur_pending', 'cuti_pending'));
    })->name('index');

    Route::resource('departments', DepartmentController::class);
    Route::get('departments/get', [DepartmentController::class, 'getData'])->name('departments.get');
    // Route::post('departments/sync-positions', [DepartmentController::class, 'syncPositions'])->name('departments.syncPositions');

    Route::resource('positions', PositionController::class);
    Route::get('positions/get', [PositionController::class, 'getData'])->name('positions.get');

    Route::resource('users', UsersController::class);

    Route::get('leaves/create/{type?}', [LeaveController::class, 'create'])->name('leaves.create');
    Route::get('leaves/{type?}/{status?}', [LeaveController::class, 'index'])->name('leaves.index');
    Route::post('leaves/store', [LeaveController::class, 'store'])->name('leaves.store');
    Route::get('/leaves/edit/{id}', [LeaveController::class, 'edit'])->name('leaves.edit');
    Route::post('/leaves/update/{id}', [LeaveController::class, 'update'])->name('leaves.update');
    Route::put('leaves/update-status/', [LeaveController::class, 'updateStatus'])->name('leaves.updateStatus');

    Route::post('/users/{user_id}/edit/leave/store', [UserLeaveController::class, 'store'])->name('users.leaves.store');
    Route::get('users-leaves/{id}', [UserLeaveController::class, 'show'])->name('users.leaves.show');
    Route::put('users-leaves/{id}/update', [UserLeaveController::class, 'update'])->name('users.leaves.update');
    Route::delete('users-leaves/{id}/destroy', [UserLeaveController::class, 'destroy'])->name('users.leaves.destroy');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
