<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CharacterController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tareas', [CharacterController::class, 'index']);

Route::put('/tareas/actualizar',  [CharacterController::class, 'update']);

Route::post('/tareas/guardar', [CharacterController::class, 'store']);

Route::delete('/tareas/borrar/{id}', [CharacterController::class, 'destroy']);

Route::get('/tareas/buscar', [CharacterController::class, 'show']);

// /home/human/Documents/picklerick/app/Http/Controllers/CharacterController.php
// Route::get('/user/{id}', [UserController::class, 'show']);