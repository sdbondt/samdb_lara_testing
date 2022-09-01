<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodoListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('/todolist', [TodoListController::class, 'index'])->name('todolist.index');
    Route::get('/todolist/{todolist}', [TodoListController::class, 'show'])->name('todolist.show');
    Route::post('/todolist', [TodoListController::class, 'store'])->name('todolist.store');
    Route::delete('/todolists/{todolist}', [TodoListController::class, 'destroy'])->name('todolist.delete');
    Route::patch('/todolists/{todolist}', [TodoListController::class, 'update'])->name('todolist.update');

    Route::get('/todolist/{todolist}/tasks', [TaskController::class, 'index'])->name('task.index');
    Route::post('/todolist/{todolist}/tasks', [TaskController::class, 'store'])->name('task.store');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('task.destroy');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('task.update');
});



Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');