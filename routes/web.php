<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Controllers\Admin\PersonalInfoController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\WorkExperienceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\ARModelController;
use App\Http\Controllers\Admin\UserProfileLinkController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\ThemeController;

// Public
Route::get('/explore', [PortfolioController::class, 'publicIndex'])->name('portfolios.public');
Route::get('/p/{slug}', [PortfolioController::class, 'showBySlug'])->name('portfolios.public.show');
Route::get('/portfolio/{slug}', [PortfolioController::class, 'showBySlug'])->name('member.portfolio.showByName');

// Smart home — never put login behind guest with name "home" (causes redirect loops)
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('member.dashboard');
    }

    return redirect()->route('auth.login');
})->name('home');

Route::group(['middleware' => 'guest'], function () {
    Route::get('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('login/process', [AuthController::class, 'loginProcess'])->name('auth.login.process');
    Route::get('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('register/process', [AuthController::class, 'registerPost'])->name('auth.register.process');
});

Route::group(['middleware' => 'auth'], function () {
    Route::match(['get', 'post'], 'logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');

    // Multi-portfolio management (members + admins)
    Route::get('/portfolios', [PortfolioController::class, 'index'])->name('portfolios.index');
    Route::get('/portfolios/create', [PortfolioController::class, 'create'])->name('portfolios.create');
    Route::post('/portfolios', [PortfolioController::class, 'store'])->name('portfolios.store');
    Route::get('/portfolios/{portfolio}/manage', [PortfolioController::class, 'manage'])->name('portfolios.manage');
    Route::get('/portfolios/{portfolio}/edit', [PortfolioController::class, 'edit'])->name('portfolios.edit');
    Route::put('/portfolios/{portfolio}', [PortfolioController::class, 'update'])->name('portfolios.update');
    Route::delete('/portfolios/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolios.destroy');
    Route::post('/portfolios/{portfolio}/select', [PortfolioController::class, 'select'])->name('portfolios.select');
    Route::get('/portfolios/{portfolio}/preview', [PortfolioController::class, 'show'])->name('portfolios.preview');

    // Content CRUD for active portfolio
    Route::resources([
        'personal_info' => PersonalInfoController::class,
        'education' => EducationController::class,
        'skills' => SkillController::class,
        'work_experiences' => WorkExperienceController::class,
        'projects' => ProjectController::class,
        'services' => ServiceController::class,
        'armodels' => ARModelController::class,
        'user-profile-links' => UserProfileLinkController::class,
    ]);

    Route::group([
        'middleware' => ['member'],
        'prefix' => 'member',
        'as' => 'member.',
    ], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'memberDashboard'])->name('dashboard');
    });

    Route::group([
        'middleware' => ['admin'],
        'prefix' => 'admin',
        'as' => 'admin.',
    ], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('themes', [ThemeController::class, 'index'])->name('themes.index');
        Route::get('users', [UserManagementController::class, 'index'])->name('users.index');
        Route::get('users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [UserManagementController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    });
});
