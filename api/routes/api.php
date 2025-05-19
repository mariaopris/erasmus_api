<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\IscedCodeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RecommendationCriterionController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'] )->name('login');
Route::post('/attempt-login', [App\Http\Controllers\LoginController::class, 'attemptLogin'] )->name('attemptLogin');

Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register'] )->name('register');
Route::post('/attempt-register', [App\Http\Controllers\RegisterController::class, 'attemptRegister'] )->name('attemptRegister');

Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout']);

Route::apiResources(
    [
        'users' => App\Http\Controllers\UserController::class,
    ]
);


Route::group([
    'middleware' => [
        'auth:sanctum',
    ]
], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/getUser', [App\Http\Controllers\UserController::class, 'getUser']);

    Route::post('/import-universities', [UniversityController::class, 'import']);
    Route::post('/upload-application-files', [ApplicationController::class, 'uploadFiles']);
    Route::post('/upload-document', [DocumentController::class, 'uploadDocument']);
    Route::get('/user-tickets/{user_id}', [TicketController::class, 'getUserTickets']);
    Route::get('/user-applications/{user_id}', [ApplicationController::class, 'getUserApplications']);
    Route::get('/get-document/{id}', [DocumentController::class, 'getDocument']);

    Route::get('/get-dashboard-data', [FeedbackController::class, 'getDashboardData']);

    Route::apiResources(
        [
            'universities' => UniversityController::class,
            'isced-codes' => IscedCodeController::class,
            'tickets' => TicketController::class,
            'messages' => MessageController::class,
            'applications' => ApplicationController::class,
            'departments' => DepartmentController::class,
            'degrees' => DegreeController::class,
            'courses' => CourseController::class,
            'countries' => CountryController::class,
            'languages' => LanguageController::class,
            'recommendations' => RecommendationCriterionController::class,
            'steps' => StepController::class,
            'user' => UserController::class,
            'documents' => DocumentController::class,
            'feedbacks' => FeedbackController::class,
            'notifications' => NotificationController::class,
        ]
    );
});

