<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ImageController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





//API route for register new user & login user.............
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//API route for forgot & reset password....................
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetpass']);



Route::group(['middleware' => ['auth:sanctum']], function () {

    // API route for logout user..........................
    Route::post('/logout', [AuthController::class, 'logout']);

    //API route for image...................................
    Route::get('/images/{id}', [ImageController::class, 'images']);
    Route::post('/image/create', [ImageController::class, 'create']);
    Route::delete('/image/delete/{id}', [ImageController::class, 'delete']);

    //Image download
    Route::get('image/{filename}', [ImageController::class, 'getFile']);
});