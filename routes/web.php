<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\PricingPlansController;


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Pricing Plans Management
        Route::get('/pricing-plans', [PricingPlansController::class, 'index'])->name('pricing-plans.index');
        Route::get('/pricing-plans/show/{id?}', [PricingPlansController::class, 'createOrEdit'])->name('pricing-plans.createOrEdit');
        Route::post('pricing-plans/save', [PricingPlansController::class, 'storeOrUpdate'])->name('pricing-plans.storeOrUpdate');
        Route::delete('/pricing-plans/delete/{pricingPlan}', [PricingPlansController::class, 'destroy'])->name('pricing-plans.destroy');
    });
});

Route::middleware(['auth', 'role:company'])->group(function () {
    Route::prefix('company')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('company.dashboard');
    });
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('user.dashboard');
});


Route::get('lang/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});

Route::get('/set-theme/{mode}', function ($mode) {
    if (! in_array($mode, ['light', 'dark'])) {
        $mode = 'light';
    }
    Session::put('theme', $mode);
    return back();
})->name('set-theme');


Route::get('/test-session', function () {
    return session('locale', 'none');
});

Route::get('/test-locale', function () {
    return app()->getLocale();
});
