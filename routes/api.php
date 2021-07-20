<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ConversationController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\RateController;
use App\Http\Controllers\API\SubjectController;
use App\Http\Controllers\API\UserController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/token', function () {
    return response()->json([
        'token' => csrf_token(),
    ]);
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::group(['prefix' => 'user', 'middleware' => ['auth:api']], function () {
    Route::get('/info/{id?}', [UserController::class, 'getInfo']);
    Route::get('/subject', [UserController::class, 'getSubjects']);
    Route::post('/subject', [UserController::class, 'updateSubjects']);
    Route::get('/profile/{user?}', [UserController::class, 'getProfile']);
    Route::post('/profile', [UserController::class, 'updateProfile']);
});

Route::group(['prefix' => 'subject', 'middleware' => ['auth:api']], function () {
    Route::get('/', [SubjectController::class, 'getSubjects']);
    Route::get('/{subject:id}', [SubjectController::class, 'getSubject']);
    Route::post('/', [SubjectController::class, 'addSubject']);
    Route::put('/{subject:id}', [SubjectController::class, 'editSubject']);
    Route::get('/find/{keyword}', [SubjectController::class, 'findSubjects']);
});

Route::group(['prefix' => 'post', 'middleware' => ['auth:api']], function () {
    Route::get('/', [PostController::class, 'getAllPosts']);
    Route::get('/own', [PostController::class, 'getOwnPosts']);
    Route::get('/recommended', [PostController::class, 'getRecommendedPosts']);
    Route::get('/{post:id}', [PostController::class, 'getPost']);
    Route::post('/', [PostController::class, 'addPost']);
    Route::put('/{post:id}', [PostController::class, 'editPost']);
    Route::get('/{post:id}/tutor', [PostController::class, 'getPostTutor']);
    Route::post('/{post:id}/tutor', [PostController::class, 'handleTutor']);
    Route::get('/{post:id}/applicant', [PostController::class, 'getPostApplicants']);
    Route::post('/{post:id}/applicant', [PostController::class, 'addPostApplicant']);
});

Route::group(['prefix' => 'conversation', 'middleware' => ['auth:api']], function () {
    Route::get('/', [ConversationController::class, 'getConversations']);
    Route::post('/', [ConversationController::class, 'addConversation']);
    Route::get('/{conversation:id}', [ConversationController::class, 'getConversation']);
    Route::get('/{conversation:id}/message', [ConversationController::class, 'getMessages']);
    Route::post('/{conversation:id}/message', [ConversationController::class, 'addMessage']);
});

Route::group(['prefix' => 'rate', 'middleware' => ['auth:api']], function () {
    Route::get('/{user:id}', [RateController::class, 'getTutorRates']);
    Route::post('/{user:id}', [RateController::class, 'evaluateTutor']);
});
