<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/todo',[TodoController::class,'index']);

Route::post('/todo', [TodoController::class,'store']);

Route::post('/markAsCompleted/{id}',[TodoController::class,'markAsCompleted']);

Route::delete('/todo/{id}',[TodoController::class,'delete']);
