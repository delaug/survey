<?php

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\User\SurveyController;
use App\Http\Controllers\API\User\QuestionController;
use App\Http\Controllers\API\User\AnswerController;

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

Route::prefix('v1')->group(function () {
    /*
     * Public routes
     */
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::apiResources(['surveys' => SurveyController::class], ['only' => ['index','show']]);

    /*
     * User auth routes
     */
    Route::group(['middleware'=>'auth:sanctum'], function () {
        Route::apiResources(['questions' => QuestionController::class], ['only' => ['index','show']]);
        Route::apiResources(['answers' => AnswerController::class]);
    });

    /*
     * Protected routes
     */

    // Unhandled routes
    Route::any('{any}', function () {
        return response()->json(['status' => Response::HTTP_NOT_FOUND], Response::HTTP_NOT_FOUND);
    })->where(['any' => '(.*)']);
});
