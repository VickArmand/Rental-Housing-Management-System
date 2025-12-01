<?php

use App\Http\Controllers\CaretakerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => '/caretaker'], function() {
        Route::post('/store', [CaretakerController::class, 'store']);
    });
});
