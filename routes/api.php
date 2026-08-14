<?php

use App\Http\Controllers\CareerAnalysisController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/career/analyze', [CareerAnalysisController::class, 'analyze'])->middleware('auth:sanctum');
