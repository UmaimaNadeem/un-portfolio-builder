<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Controllers\Admin\PersonalInfoController;
use App\Http\Controllers\Admin\EducationController;
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

    Route::group([
        'middleware' => ['admin'],
        'prefix' => 'admin',
    ], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        Route::resources([
            'personal_info' => PersonalInfoController::class,
            'education' => EducationController::class,
            'skills' => SkillController::class,
            'work_experiences' => WorkExperienceController::class,
            'projects' => ProjectController::class, 'personal_info' => PersonalInfoController::class,
            'education' => EducationController::class,
            'skills' => SkillController::class,
            'work_experiences' => WorkExperienceController::class,
            'projects' => ProjectController::class,
            'armodels' => ARModelController::class,
            'user-profile-links' => UserProfileLinkController::class,
        ]);

        Route::get('/armodels/{armodel}/edit', [ARModelController::class, 'edit'])->name('armodels.edit');
        Route::get('/armodels/{armodel}', [ARModelController::class, 'show'])->name('armodels.show');
        
        Route::get('/portfolio/{user}', [PortfolioController::class, 'show'])->name('portfolio.show');
        Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');

    });

    Route::group([
        'middleware' => ['member'],
        'prefix' => 'member',
    ], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('member.dashboard');
       });

});



