<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PersonalInfoController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\WorkExperienceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('admin')) {
        return redirect()->route('pages.admin');
    } elseif ($user->hasRole('user')) {
        return redirect()->route('pages.user');
    }
    abort(403, 'Unauthorized action.');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group([
    'middleware' => ['auth', 'role:admin'],
    'prefix' => 'admin',
], function () {
    // Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', function () {
        return view('pages.admin');
    })->name('pages.admin');

    Route::resources([
        'personal_info' => PersonalInfoController::class,
        'education' => EducationController::class,
        'skills' => SkillController::class,
        'work_experiences' => WorkExperienceController::class,
        'projects' => ProjectController::class,
    ]);

    Route::get('/portfolio/{user}', [PortfolioController::class, 'show'])->name('portfolio.show');

});


Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('pages.user');
    })->name('pages.user');
});

require __DIR__.'/auth.php';

