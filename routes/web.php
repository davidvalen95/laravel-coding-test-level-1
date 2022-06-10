<?php

use Illuminate\Support\Facades\Route;

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


Route::prefix("events")->middleware('auth')->group(function(){
    Route::get('{id}/edit', [\App\Http\Controllers\EventController::class, 'form'])->name('events.edit');
    Route::get('create', [\App\Http\Controllers\EventController::class, 'form'])->name('events.create');

    Route::get('active-events', [\App\Http\Controllers\EventController::class, 'activeEvents'])->name('activeEvents');
    Route::get('{id?}', [\App\Http\Controllers\EventController::class, 'get'])->name('events.get');

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
