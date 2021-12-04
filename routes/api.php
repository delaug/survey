<?php

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\User\SurveyController;
use App\Http\Controllers\API\User\QuestionController;
use App\Http\Controllers\API\User\AnswerController;
use App\Http\Controllers\API\Admin\UserController as AdmUserController;
use App\Http\Controllers\API\Admin\RoleController as AdmRoleController;
use App\Http\Controllers\API\Admin\SurveyController as AdmSurveyController;
use App\Http\Controllers\API\Admin\QuestionController as AdmQuestionController;
use App\Http\Controllers\API\Admin\QuestionTypeController as AdmQuestionTypeController;
use App\Http\Controllers\API\Admin\FieldController as AdmFieldController;
use App\Http\Controllers\API\Admin\MediaController as AdmMediaController;

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
    Route::apiResources(['surveys' => SurveyController::class], ['only' => ['index', 'show']]);

    /*
     * User auth routes
     */
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::apiResources(['questions' => QuestionController::class], ['only' => ['index']]);
        Route::apiResources(['answers' => AnswerController::class], ['only' => ['store']]);
    });

    /*
     * Protected routes
     */
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });

    /*
     * Admin route
     */
    Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
        Route::apiResources([
            'users' => AdmUserController::class,
            'roles' => ADmRoleController::class,
            'surveys' => ADmSurveyController::class,
            'questions' => AdmQuestionController::class,
            'fields' => AdmFieldController::class,

        ],
            ['parameters' => [ 'users' => 'subject']]);

        Route::apiResources(['media' => AdmMediaController::class], [
            'parameters' => ['media' => 'media'],
            'except' => ['update']
        ]);

        Route::get('surveys/{survey}/questions', [AdmSurveyController::class, 'indexQuestions']);
        Route::apiResources(['question-types' => AdmQuestionTypeController::class], ['only' => ['index']]);

    });

    // Unhandled routes
    Route::any('{any}', function () {
        return response()->json(['status' => Response::HTTP_NOT_FOUND], Response::HTTP_NOT_FOUND);
    })->where(['any' => '(.*)']);
});
