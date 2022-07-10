<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\TripController;


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
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);   
    Route::post('/store','App\Http\Controllers\ActivityController@store'); 
    Route::get('/show','App\Http\Controllers\ActivityController@show'); 
    Route::post('/insert-activity/{id}','App\Http\Controllers\ActivityController@insert_user_activities'); 
    Route::get('/show-activity','App\Http\Controllers\ActivityController@show_user_activities'); 
    Route::post('/region', [AreaController::class,'storeRegion']);
    Route::post('/addGov', [TripController::class,'store']);
});