<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/clear-cache', [DashboardController::class, 'clearCache'])->name('admin.clear-cache');

    // User Routes
    Route::get('/dashboard/users', [UserController::class, 'index'])->name('users');
    Route::get('/dashboard/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/dashboard/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/dashboard/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/dashboard/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/dashboard/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    Route::post('/dashboard/user/assign-role', [UserController::class, 'assignRole'])->name('user.assignRole');

    // Role Routes
    Route::get('/dashboard/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/dashboard/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/dashboard/role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/dashboard/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
    Route::post('/dashboard/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::get('/dashboard/role/delete/{id}', [RoleController::class, 'destroy'])->name('role.delete');

    // CKEditor Routes
    Route::get('ckeditor', [\App\Http\Controllers\CkeditorController::class, 'index']);
    Route::post('ckeditor/upload', [\App\Http\Controllers\CkeditorController::class, 'upload'])->name('ckeditor.upload');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
