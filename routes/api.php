<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\DailyProgramController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DatedayController;
use App\Http\Controllers\GovernementController;
use App\Http\Controllers\StateController;
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
    Route::post('/addTrip', [TripController::class,'store']);
    Route::post('/addGov', [GovernementController::class,'addGov']);
    Route::post('/selectGov/{trip_id}/{gov_id}', [GovernementController::class,'selectGov']);
    Route::post('/addState', [StateController::class,'addState']);
    Route::post('/selectState/{trip_id}/{state_id}', [StateController::class,'selectState']);
    Route::post('/addArea', [AreaController::class,'addArea']);
    Route::post('/selectCountry_City/{trip_id}', [AreaController::class,'selectCountry_City']);
    Route::post('/selectArea/{trip_id}/{area_id}', [AreaController::class,'selectArea']);

    Route::post('/addEvent/{id}', [EventController::class,'addEvent']);
    Route::post('/addDay/{id}', [DatedayController::class,'addDay']);
    Route::post('/addDailyProgram/{id}', [DailyProgramController::class,'addDailyProgram']);
    Route:: get('/showTrip',[TripController::class,'showTrip']);
    Route:: get('/listAll',[TripController::class,'listAlltrip']);
    Route:: get('/searchName/{string}',[TripController::class,'search_name']);
    Route:: get('/searchNameTeam/{string}',[TripController::class,'search_name_team']);
    Route:: get('/searchPrice/{int}',[TripController::class,'search_price']);
    Route:: get('/searchType/{int}',[TripController::class,'search_type']);
    Route:: get('/searchAge/{int}',[TripController::class,'search_age']);
    Route:: get('/searchCoutinent/{int}',[TripController::class,'search_coutinent']);
    Route:: delete('deleteTrip/{id}',[TripController::class,'delet_trip']);
    Route:: get('/search/{int}',[TripController::class,'search']);
    
Route::get('/post-list',[PostController::class,'postList'])->name('post.list');
Route::post('/like-post/{id}',[PostController::class,'likePost'])->name('like.post');
Route::post('/unlike-post/{id}',[PostController::class,'unlikePost'])->name('unlike.post');

Route::post('/register/{user_id}/{trip_id}', [TripController::class,'register']);
Route::post('/registerTrip/{trip_id}', [TripController::class,'registerTrip']);
Route::post('/registerUser/{user_id}', [TripController::class,'registerUser']);
});