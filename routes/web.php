<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyInfoController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\OrderServiceController;
use App\Http\Controllers\FaqManagementController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\OrderManagementController;
use App\Http\Controllers\GalleryManagementController;
use App\Http\Controllers\ServiceManagementController;
use App\Http\Controllers\TestimonialManagemController;

Route::get('/', [LandingPageController::class, 'index'])->name('landingpage');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Superadmin
    Route::group(['middleware' => ['role:superadmin']], function () {
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::put('company-info/create_or_update', [CompanyInfoController::class, 'CreateOrUpdate'])
                ->name('company-info.create_or_update');
            Route::resource('company-info', CompanyInfoController::class)
                ->only(['index']);
        });
    });

    // admin
    Route::group(['middleware' => ['role:admin|superadmin']], function () {
        Route::prefix('dashboard')->name('dashboard.')->group(function () {

            Route::patch('order-management/{id}/status', [OrderManagementController::class, 'updateStatus'])
                ->name('order-management.status');
            Route::resource('order-management', OrderManagementController::class)
                ->only(['index', 'show', 'updateStatus']);

            Route::resource('testimonial-management', TestimonialManagemController::class)
                ->only(['index', 'show']);

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
