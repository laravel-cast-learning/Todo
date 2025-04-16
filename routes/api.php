<?php

use Illuminate\Support\Facades\Route;

Route::get('/todo',function(){
    return json_encode(['Hello World']);
});
