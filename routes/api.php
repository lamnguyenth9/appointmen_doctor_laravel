<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login',[UserController::class,'login']);
Route::post('/register',[UserController::class,'register']);
Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user',[UserController::class,'index']);
    Route::post('/book',[AppointmentController::class,'store']);
    Route::post('/reviews',[DocsController::class,'store']);
    Route::get('/appointments',[AppointmentController::class,'index']);
});
