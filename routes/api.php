<?php

use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TaskController;
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

Route::post('register', [RegistrationController::class, 'register']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('tasks', [TaskController::class, 'makeCompilation']);
    Route::put('{task}/completed', [TaskController::class, 'markCompleted']);
});
