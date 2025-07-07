<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
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
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [AuthController::class, 'login'])->name('home');
    Route::get('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('login/process', [AuthController::class, 'loginProcess'])->name('auth.login.process');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::get('/portfolio/{user}', [PortfolioController::class, 'show'])->name('portfolio.show');
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
    'middleware' => ['auth', 'member'],
    'prefix' => 'member',
    'as' => 'member.',
], function () {
    Route::get('dashboard', [AdminDashboardController::class, 'memberDashboard'])->name('dashboard');
    Route::get('personal_info', [PersonalInfoController::class, 'index'])->name('member.personal_info.index');

   
});

    Route::group([
        'middleware' => ['admin'],
        'prefix' => 'admin',
    ], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/armodels/{armodel}/edit', [ARModelController::class, 'edit'])->name('armodels.edit');
        Route::get('/armodels/{armodel}', [ARModelController::class, 'show'])->name('armodels.show');

        Route::get('/portfolio/create', [PortfolioController::class, 'create'])->name('portfolio.create');

        Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
        Route::post('/portfolio/store', [PortfolioController::class, 'storeFullPortfolio'])->name('portfolio.store');

    });



});



