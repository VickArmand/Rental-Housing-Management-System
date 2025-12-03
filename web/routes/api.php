<?php

use App\Http\Controllers\CaretakerController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\ReminderStatusController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\RentalDueController;
use App\Http\Controllers\RentalExpenseController;
use App\Http\Controllers\RentalIncomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TenantReminderController;
use App\Http\Controllers\TenantReminderStatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
Route::post('/reset-password', [UserController::class, 'resetPassword']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [UserController::class, 'userDetails'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => '/caretakers'], function() {
        Route::get('/', [CaretakerController::class, 'index']);
        Route::get('/find', [CaretakerController::class, 'show']);
        Route::post('/create', [CaretakerController::class, 'store']);
        Route::put('/edit', [CaretakerController::class, 'update']);
        Route::delete('/delete', [CaretakerController::class, 'dele']);
    });
    Route::resource('owners', OwnerController::class);
    Route::resource('rentals', RentalController::class);
    Route::resource('room', RoomController::class);
    Route::resource('reminders', ReminderController::class);
    Route::resource('reminderstatuses', ReminderStatusController::class);
    Route::resource('dues', RentalDueController::class);
    Route::resource('expenses', RentalExpenseController::class);
    Route::resource('incomes', RentalIncomeController::class);
    Route::resource('subscriptions', SubscriptionController::class);
    Route::resource('tenants', TenantController::class);
    Route::resource('tenantreminders', TenantReminderController::class);
    Route::resource('tenantreminderstatuses', TenantReminderStatusController::class);
    Route::resource('users', UserController::class);
    Route::resource('usersubscriptions', UserSubscriptionController::class);
});
