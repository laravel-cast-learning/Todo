<?php

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/todo',function(){
    return response()->json([
        'todos' => Todo::all()
    ]);
});

Route::post('/todo',function (Request $request){
    $validated = $request->validate([
        'title' => 'required',
        'description' => 'required'
    ]);
    return response()->json([Todo::create($validated)]);
});

Route::post('/todo/{id}',function ($id){
    $todo = Todo::find($id);
    $todo->completed = true;
    $todo->save();
    return response()->json([$todo]);
});

Route::delete('/todo/{id}',function ($id){
    $todo = Todo::find($id);
    $todo->delete();
    return response()->json([$todo]);
});
