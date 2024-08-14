<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landingpage');
});


Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/dashboard/admin', function () {
        return 'test';
    })->name('dashboard.admin');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
