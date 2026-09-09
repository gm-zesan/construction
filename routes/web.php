<?php

use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ArticleController as PublicArticleController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProjectController as PublicProjectController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Website Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/projects', [PublicProjectController::class, 'index'])->name('public.projects.index');
Route::get('/projects/{slug}', [PublicProjectController::class, 'show'])->name('public.projects.show');
Route::get('/articles', [PublicArticleController::class, 'index'])->name('public.articles.index');
Route::get('/articles/{slug}', [PublicArticleController::class, 'show'])->name('public.articles.show');

/*
|--------------------------------------------------------------------------
| Admin Portal Routes
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\ArticleCategoryController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CkeditorController;
use App\Http\Controllers\Admin\ClientEnquiryController;
use App\Http\Controllers\Admin\ClientReviewController;
use App\Http\Controllers\Admin\ContentManagementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProjectMilestoneController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WebsiteSettingController;

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
    Route::resource('/dashboard/permissions', PermissionController::class)->names('permissions');

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

    // Client Review Routes
    Route::post('/dashboard/client-reviews/{id}/toggle-status', [ClientReviewController::class, 'toggleStatus'])->name('client-reviews.toggle-status');
    Route::resource('dashboard/client-reviews', ClientReviewController::class)->names('client-reviews');

    // Team Member Routes
    Route::post('/dashboard/team-members/{id}/toggle-status', [TeamMemberController::class, 'toggleStatus'])->name('team-members.toggle-status');
    Route::resource('dashboard/team-members', TeamMemberController::class)->names('team-members');

    // Activity Log Routes
    Route::resource('dashboard/activity-logs', ActivityLogController::class)->only(['index', 'show'])->names('activity-logs');

    // Project Milestone Routes
    Route::post('/dashboard/milestones/{id}/toggle-status', [ProjectMilestoneController::class, 'toggleStatus'])->name('milestones.toggle-status');
    Route::resource('dashboard/milestones', ProjectMilestoneController::class)->names('milestones');

    // Media Library Routes
    Route::resource('dashboard/media', MediaController::class)->names('media');

    // Article Category Routes
    Route::post('/dashboard/article-categories/{id}/toggle-status', [ArticleCategoryController::class, 'toggleStatus'])->name('article-categories.toggle-status');
    Route::resource('dashboard/article-categories', ArticleCategoryController::class)->names('article-categories');

    // News & Article Routes
    Route::post('/dashboard/articles/{id}/toggle-status', [ArticleController::class, 'toggleStatus'])->name('articles.toggle-status');
    Route::post('/dashboard/articles/{id}/toggle-featured', [ArticleController::class, 'toggleFeatured'])->name('articles.toggle-featured');
    Route::resource('dashboard/articles', ArticleController::class)->names('articles');

    // Website Content Management Workspace (Page Sections)
    Route::get('/dashboard/content-management', [ContentManagementController::class, 'index'])->name('content-management.index');
    Route::post('/dashboard/content-management', [ContentManagementController::class, 'update'])->name('content-management.update');
    Route::post('/dashboard/content-management/fields', [ContentManagementController::class, 'storeField'])->name('content-management.fields.store');
    Route::delete('/dashboard/content-management/fields/{id}', [ContentManagementController::class, 'destroyField'])->name('content-management.fields.destroy');

    // Global Website Settings (General, Contact, Social, Business, Dynamic Custom Fields)
    Route::get('/dashboard/settings', [WebsiteSettingController::class, 'index'])->name('settings.index');
    Route::post('/dashboard/settings', [WebsiteSettingController::class, 'update'])->name('settings.update');
    Route::post('/dashboard/settings/fields', [WebsiteSettingController::class, 'storeField'])->name('settings.fields.store');
    Route::delete('/dashboard/settings/fields/{id}', [WebsiteSettingController::class, 'destroyField'])->name('settings.fields.destroy');

    // CKEditor Media Upload Endpoint
    Route::post('ckeditor/upload', [CkeditorController::class, 'upload'])->name('ckeditor.upload');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
