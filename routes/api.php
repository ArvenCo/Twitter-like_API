<?php
use App\Http\Controllers\AuthController;

use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserFileController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('user')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/login', function(){return response(['message'=>'Unauthorized'],401); })->name('login');
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});




Route::group(['middleware' => ['auth:sanctum']],function(){
    Route::get('/', function(){return ['message'=>'Connection Succes'];});
    
    
    Route::group(['prefix' => '/tweet'], function(){
        Route::post('/',[TweetController::class, 'store']);
        Route::put('/{tweet_id}',[TweetController::class, 'update']);
        Route::delete('/{tweet_id}',[TweetController::class, 'destroy']);
    });
    
});

Route::get('/hello',function(){
    return response(['message'=>'Hello World'],200);
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
