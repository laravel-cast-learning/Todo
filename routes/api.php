<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/todo',function(){
    return json_encode(['Hello World']);
});

Route::post('/todo',function (Request $request){
    dd($request);
});
