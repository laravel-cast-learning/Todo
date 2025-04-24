<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/todo',[TodoController::class,'index'])->middleware('auth:sanctum');
Route::post('/todo', [TodoController::class,'store'])->middleware('auth:sanctum');
Route::post('/markAsCompleted/{id}',[TodoController::class,'markAsCompleted'])->middleware('auth:sanctum');
Route::delete('/todo/{id}',[TodoController::class,'delete'])->middleware('auth:sanctum');

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
