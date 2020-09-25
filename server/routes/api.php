<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\DashboardController;
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
// middleware('auth:api')->
Route::get('/user', function (Request $request) {
    return $request->user();
    return App\Models\User::latest()->first();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/jobs', [JobController::class, 'index']);

Route::middleware('auth:api')->group(function(){
	Route::post('/logout', [AuthController::class, 'logout']);

	//Registeruser
	Route::get('/user', function (Request $request) {
	    return $request->user();
	});
	
	//Jobs
	Route::get('/employer/jobs', [DashboardController::class, 'index']);
	Route::post('/jobs', [JobController::class, 'store']);
	Route::patch('/jobs/{job}', [JobController::class, 'update']);
	Route::delete('/jobs/{job}', [JobController::class, 'destroy']);

	// Route::resource('jobs', [AuthController::class]);
});
