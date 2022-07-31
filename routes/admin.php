<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ActivityController;


use App\Http\Controllers\DailyProgramController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DatedayController;
use App\Http\Controllers\GovernementController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\AdminController;


Route::group(['prefix' => 'admin','middleware' => ['assign.guard:admin','jwt.auth']],function ()
{
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/register', [AdminController::class, 'register']);
});