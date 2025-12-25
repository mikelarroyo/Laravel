<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartController;
use App\Http\Controllers\EmpleController;
use App\Http\Controllers\controlladorPrueba;

Route::get('/', function () {
    return view('home');
});

Route::resource('departs', DepartController::class);
Route::resource('emples', EmpleController::class);
Route::get('/saludo/{nombre?}', [ControlladorPrueba::class, 'saludo'])->where('nombre', '[a-z]+');
Route::get('/departamento/{id}', [ControlladorPrueba::class,'mostrar']);

