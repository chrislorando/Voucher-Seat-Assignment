<?php

use App\Http\Controllers\VoucherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/check', [VoucherController::class, 'check']);
Route::post('/generate', [VoucherController::class, 'generate']);