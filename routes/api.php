<?php
use App\Http\Controllers\AuthController;

use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserFileController;
use App\Http\Controllers\FollowController;

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
    
    Route::group(['prefix' => '/tweet'], function(){
        Route::post('/',[TweetController::class, 'store']);
        Route::put('/{tweet_id}',[TweetController::class, 'update']);
        Route::delete('/{tweet_id}',[TweetController::class, 'destroy']);
    });

    /**
     * follow unfollow user
     */
    Route::group(['prefix' => '/follow'], function(){
        Route::get('/',[FollowController::class, 'random_index']);
        Route::post('/',[FollowController::class,'store']);
        Route::delete('/{follow_user_id}',[FollowController::class, 'destroy']);
    });
    
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
