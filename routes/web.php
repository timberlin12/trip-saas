<?php

use Illuminate\Support\Facades\Route;


Route::get('lang/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});
Route::get('/set-theme/{mode}', function ($mode) {
    if (! in_array($mode, ['light', 'dark'])) {
        $mode = 'light';
    }
    Session::put('theme', $mode);
    return back(); // go back to previous page
})->name('set-theme');

Route::get('/', function () {
    return view('index');
})->name('adminDashboard');

Route::get('/test-session', function () {
    return session('locale', 'none');
});
Route::get('/test-locale', function () {
    return app()->getLocale();
});
