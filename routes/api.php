<?php

use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// User APIs
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/users/{id}/subscriptions', [SubscriptionController::class, 'userSubscriptionHistory']);

// Subscription APIs
Route::get('/subscriptions', [SubscriptionController::class, 'index']);
Route::post('/subscriptions/purchase', [SubscriptionController::class, 'purchase']);

// Dashboard API
Route::get('/dashboard/{user_id}', [UserController::class, 'dashboard']);
