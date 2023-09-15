<?php
use App\Http\Controllers\AuthController;

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
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/login', function(){return response(['message'=>'Unauthorized'],401); })->name('login');
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});




Route::group(['middleware' => ['auth:sanctum']],function(){
    Route::get('/', function(){return ['message'=>'Connection Succes'];});
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
