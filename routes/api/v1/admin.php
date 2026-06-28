<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AdminDashboardController;
use App\Http\Controllers\Api\Admin\AdminUserController;
use App\Http\Controllers\Api\Admin\AdminRoomController;
use App\Http\Controllers\Api\Admin\AdminFinanceController;
use App\Http\Controllers\Api\Admin\AdminContentController;

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {

    // ── Dashboard & Analytics ────────────────
    Route::get('/dashboard',        [AdminDashboardController::class, 'index']);
    Route::get('/analytics',        [AdminDashboardController::class, 'analytics']);
    Route::get('/search-analytics', [AdminDashboardController::class, 'searchAnalytics']);

    // ── User & Owner Management ─────────────
    Route::get('/users',                    [AdminUserController::class, 'users']);
    Route::get('/users/{id}',               [AdminUserController::class, 'userDetail']);
    Route::post('/users/{id}/toggle-block', [AdminUserController::class, 'toggleBlockUser']);
    
    Route::get('/owners',                   [AdminUserController::class, 'owners']);
    Route::post('/owners',                  [AdminUserController::class, 'createOwner']);
    Route::get('/owners/{id}',              [AdminUserController::class, 'ownerDetail']);
    Route::post('/owners/{id}/toggle-block', [AdminUserController::class, 'toggleBlockOwner']);

    // ── Room Management ─────────────────────
    Route::get('/rooms',                    [AdminRoomController::class, 'index']);
    Route::post('/rooms/{id}/approve',      [AdminRoomController::class, 'approve']);
    Route::post('/rooms/{id}/reject',       [AdminRoomController::class, 'reject']);
    Route::delete('/rooms/{id}',            [AdminRoomController::class, 'destroy']);
    
    // Rejection Reasons
    Route::get('/rejection-reasons',           [AdminRoomController::class, 'getReasons']);
    Route::post('/rejection-reasons',          [AdminRoomController::class, 'storeReason']);
    Route::put('/rejection-reasons/{id}',      [AdminRoomController::class, 'updateReason']);
    Route::delete('/rejection-reasons/{id}',   [AdminRoomController::class, 'deleteReason']);

    // ── Finance & Plans ──────────────────────
    Route::get('/payments',                 [AdminFinanceController::class, 'payments']);
    Route::get('/payouts',                  [AdminFinanceController::class, 'payouts']);
    Route::post('/payouts/{id}/process',    [AdminFinanceController::class, 'processPayout']);
    
    Route::get('/plans',                    [AdminFinanceController::class, 'plans']);
    Route::post('/plans',                   [AdminFinanceController::class, 'storePlan']);
    Route::put('/plans/{id}',               [AdminFinanceController::class, 'updatePlan']);
    Route::post('/plans/{id}/toggle',       [AdminFinanceController::class, 'togglePlan']);
    Route::delete('/plans/{id}',            [AdminFinanceController::class, 'destroyPlan']);

    // ── Content & Settings ───────────────────
    Route::get('/settings',                 [AdminContentController::class, 'getSettings']);
    Route::post('/settings',                [AdminContentController::class, 'updateSettings']);
    
    Route::get('/blogs',                    [AdminContentController::class, 'blogs']);
    Route::post('/blogs',                   [AdminContentController::class, 'storeBlog']);
    Route::put('/blogs/{id}',               [AdminContentController::class, 'updateBlog']);
    Route::delete('/blogs/{id}',            [AdminContentController::class, 'destroyBlog']);

    Route::get('/offers',                   [AdminContentController::class, 'offers']);
    Route::post('/offers',                  [AdminContentController::class, 'storeOffer']);
    Route::put('/offers/{id}',              [AdminContentController::class, 'updateOffer']);
    Route::post('/offers/{id}/toggle',      [AdminContentController::class, 'toggleOffer']);
    Route::delete('/offers/{id}',           [AdminContentController::class, 'destroyOffer']);

    Route::get('/city-alerts',              [AdminContentController::class, 'allCityAlerts']);
    Route::delete('/city-alerts/{id}',      [AdminContentController::class, 'destroyCityAlert']);
    
    Route::get('/subscribers',              [AdminContentController::class, 'subscribers']);
    Route::delete('/subscribers/{id}',      [AdminContentController::class, 'destroySubscriber']);
    
    Route::put('/pages/{slug}',             [AdminContentController::class, 'updatePage']);
});
