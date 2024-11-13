<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\IscedCodeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/import-universities', [UniversityController::class, 'import']);
Route::post('/register', [UserController::class, 'store']);
Route::post('/upload-application-files', [ApplicationController::class, 'uploadFiles']);
Route::get('/user-tickets/{user_id}', [TicketController::class, 'getUserTickets']);
Route::get('/user-applications/{user_id}', [ApplicationController::class, 'getUserApplications']);

Route::apiResources(
    [
        'universities' => UniversityController::class,
        'isced-codes' => IscedCodeController::class,
        'tickets' => TicketController::class,
        'messages' => MessageController::class,
        'applications' => ApplicationController::class,
    ]
);
