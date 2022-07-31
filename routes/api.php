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
use App\Http\Controllers\AdminActivityController;




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

Route::group(['prefix' => 'admin','middleware' =>'assign.guard:admin'],function ()
{
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/register', [AdminController::class, 'register']);
    Route::post('/Admin_add_activity', [AdminActivityController::class, 'Admin_add_activity']);
    Route::get('/show_activity', [AdminActivityController::class, 'show_activities']);
    Route::delete('/delete_activity/{id}', [AdminActivityController::class, 'delete_activity']);
    Route::post('/Admin_update_activity/{id}', [AdminActivityController::class, 'Admin_update_activity']);
    Route::get('/show_activity', [AdminActivityController::class,'show_activities']);
    Route::post('/addArea', [AreaController::class, 'addArea']);
    Route::post('/selectCountry_City/{trip_id}', [AreaController::class, 'selectCountry_City']);
    Route::post('/selectArea/{trip_id}/{area_id}', [AreaController::class, 'selectArea']);
    Route::post('/deselectArea/{trip_id}/{area_id}', [AreaController::class, 'deselectArea']);
    Route::put('/updateArea/{id}', [AreaController::class, 'updateArea']);
    Route::post('/addDay/{id}', [DatedayController::class, 'addDay']);
    Route::get('/show_days/{id}', [DatedayController::class, 'show_days']);
    Route::put('/updateDay/{id}/{day_id}', [DatedayController::class, 'updateDay']);
    Route::delete('/delete_dateday/{id}', [DatedayController::class, 'delete_dateday']);
    Route::post('/addEvent/{id}', [EventController::class, 'addEvent']);
    Route::delete('/deleteEvent/{event_id}', [EventController::class, 'deleteEvent']);

    
});

Route::group(['prefix' => 'user','middleware' => ['assign.guard:users','jwt.auth']],function ($router)
{
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
  //  Route::post('/Admin_add_activity', 'App\Http\Controllers\ActivityController@Admin_add_activity');
  //  Route::get('/show', 'App\Http\Controllers\ActivityController@show');
    Route::post('/like-trip/{id}', [TripController::class, 'likePost'])->name('like.trip');
    Route::post('/addRate/{id}', [TripController::class, 'addRate'])->name('rate.trip');
    Route::get('/home', [TripController::class, 'home'])->name('home');
    Route::post('/delete_user_activities', 'App\Http\Controllers\ActivityController@delete_user_activities');
    Route::post('/insert_user_activity', 'App\Http\Controllers\ActivityController@insert_user_activities');
    Route::get('/show_days/{id}', [UserDatedayController::class, 'show_days']);

//  Route::post('/Admin_update_activity/{id}', [ActivityController::class, 'Admin_update_activity']);
    Route::post('/deselect_trip_activities/{id}', 'App\Http\Controllers\ActivityController@deselect_trip_activities');
    Route::post('/select_trip_activities/{id}', 'App\Http\Controllers\ActivityController@select_trip_activities');
    Route::get('/show_User_activity', 'App\Http\Controllers\ActivityController@show_user_activities');
    Route::get('/show_activity', 'App\Http\Controllers\ActivityController@show_activities');
    Route::get('/show_recommended_trips', [TripController::class, 'show_recommended_trips']);
    Route::get('/show_offered_trips', [TripController::class, 'show_offered_trips']);
    Route::post('/addTrip', [TripController::class, 'store']);
    Route::post('/addGov', [GovernementController::class, 'addGov']);
    Route::post('/selectGov/{trip_id}/{gov_id}', [GovernementController::class, 'selectGov']);
    Route::post('/addState', [StateController::class, 'addState']);
    Route::post('/selectState/{trip_id}/{state_id}', [StateController::class, 'selectState']);
 //   Route::post('/selectCountry_City/{trip_id}', [AreaController::class, 'selectCountry_City']);
  //  Route::post('/selectArea/{trip_id}/{area_id}', [AreaController::class, 'selectArea']);
   // Route::post('/deselectArea/{trip_id}/{area_id}', [AreaController::class, 'deselectArea']);
    
  //  Route::delete('/delete_activity/{id}', [ActivityController::class, 'delete_activity']);
  //  Route::delete('/deleteEvent/{event_id}', [EventController::class, 'deleteEvent']);
    Route::delete('/delete_dailyprogram/{id}', [DailyProgramController::class, 'delete_dailyprogram']);
    Route::delete('/delete_trip/{id}', [TripController::class, 'delete_trip']);
   
  //  Route::post('/addEvent/{id}', [EventController::class, 'addEvent']);
  //  Route::post('/addDay/{id}', [DatedayController::class, 'addDay']);
    Route::post('/addDailyProgram/{id}', [DailyProgramController::class, 'addDailyProgram']);
});
