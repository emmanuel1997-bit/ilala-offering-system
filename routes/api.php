<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\AnnouncementController;
use App\Http\Controllers\API\ReceiptController;
use App\Http\Controllers\API\ContributionController;

    // Test route
    Route::get('/test', fn() => response()->json(['message' => 'API working!']));

   // ========== AUTH ==========
    Route::prefix('auth')->group(function () {
        Route::post('/send-consent', [AuthController::class, 'sendConsent']);
        Route::post('/verify-consent', [AuthController::class, 'verifyConsent']);
        Route::post('/set-pin', [AuthController::class, 'setPin']);
        Route::post('/verify-pin', [AuthController::class, 'verifyPin']);
    });

    // ========== PROFILE ==========

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile/update', [ProfileController::class, 'update']);

    // ========== ANNOUNCEMENTS ==========
    Route::get('/announcements', [AnnouncementController::class, 'index']);

    // ========== RECEIPTS ==========
    Route::get('/receipts', [ReceiptController::class, 'all']);
    Route::get('/receipts/{id}', [ReceiptController::class, 'show']);

    // ========== CONTRIBUTIONS ==========
    Route::get('/contributions/types', [ContributionController::class, 'types']);
    Route::post('/contributions', [ContributionController::class, 'store']);


