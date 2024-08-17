<?php

use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\FaqManagementController;
use App\Http\Controllers\GalleryManagementController;
use App\Http\Controllers\OrderServiceController;
use App\Http\Controllers\ServiceManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landingpage');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // admin
    Route::group(['middleware' => ['role:admin']], function () {
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('user-management/role/{role}', [UserManagementController::class, 'getUsersByRole'])
                ->name('user-management.role');

            Route::resource('user-management', UserManagementController::class)
                ->except(['store', 'create']);

            Route::resource('service-management', ServiceManagementController::class);
            Route::resource('faq-management', FaqManagementController::class);
            Route::resource('gallery-management', GalleryManagementController::class);
        });
    });

    // customer
    Route::group(['middleware' => ['role:customer']], function () {
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::resource('order-service', OrderServiceController::class);
        });
    });

    // therapist
    Route::group(['middleware' => ['role:therapist']], function () {
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            // Route::resource('service-management', ServiceManagementController::class);
        });
    });
});
