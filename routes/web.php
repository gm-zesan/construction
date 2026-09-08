<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ClientEnquiryController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\MediaController;

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

    // Permission Routes (Dynamic Permissions)
    Route::resource('/dashboard/permissions', \App\Http\Controllers\PermissionController::class)->names('permissions');

    // Project Routes
    Route::post('/dashboard/projects/{id}/toggle-status', [ProjectController::class, 'toggleStatus'])->name('projects.toggle-status');
    Route::delete('/dashboard/projects/{id}/media/{mediaId}', [ProjectController::class, 'deleteMedia'])->name('projects.media.destroy');
    Route::resource('dashboard/projects', ProjectController::class)->names('projects');

    // Service Routes
    Route::post('/dashboard/services/{id}/toggle-status', [ServiceController::class, 'toggleStatus'])->name('services.toggle-status');
    Route::delete('/dashboard/services/{id}/media/{mediaId}', [ServiceController::class, 'deleteMedia'])->name('services.media.destroy');
    Route::resource('dashboard/services', ServiceController::class)->names('services');

    // Client Enquiry Routes
    Route::post('dashboard/enquiries/{enquiry}/status', [ClientEnquiryController::class, 'updateStatus'])->name('enquiries.status');
    Route::resource('dashboard/enquiries', ClientEnquiryController::class)->only(['index', 'show', 'update', 'destroy'])->names('enquiries');

    // Activity Log Routes
    Route::resource('dashboard/activity-logs', ActivityLogController::class)->only(['index', 'show'])->names('activity-logs');

    // Project Milestone Routes
    Route::post('/dashboard/milestones/{id}/toggle-status', [\App\Http\Controllers\ProjectMilestoneController::class, 'toggleStatus'])->name('milestones.toggle-status');
    Route::resource('dashboard/milestones', \App\Http\Controllers\ProjectMilestoneController::class)->names('milestones');

    // Media Library Routes
    Route::resource('dashboard/media', MediaController::class)->names('media');

    // Article Category Routes
    Route::post('/dashboard/article-categories/{id}/toggle-status', [\App\Http\Controllers\ArticleCategoryController::class, 'toggleStatus'])->name('article-categories.toggle-status');
    Route::resource('dashboard/article-categories', \App\Http\Controllers\ArticleCategoryController::class)->names('article-categories');

    // News & Article Routes
    Route::post('/dashboard/articles/{id}/toggle-status', [\App\Http\Controllers\ArticleController::class, 'toggleStatus'])->name('articles.toggle-status');
    Route::post('/dashboard/articles/{id}/toggle-featured', [\App\Http\Controllers\ArticleController::class, 'toggleFeatured'])->name('articles.toggle-featured');
    Route::resource('dashboard/articles', \App\Http\Controllers\ArticleController::class)->names('articles');

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
