<?php

use App\Http\Controllers\API\{TrackController,InstructorController,CourseController,CourseTopicController};
use App\Http\Controllers\{AuthUserController, AuthAdminController};
 Route::prefix('user')->group(function () {
        // Public routes (no auth required)
        Route::post('/login', [AuthUserController::class, 'login'])->name('user.login');
        Route::post('/register', [AuthUserController::class, 'register'])->name('user.register');
        Route::post('/password/forgot', [AuthUserController::class, 'forgotPassword'])->name('user.password.forgot');
        Route::post('/password/reset', [AuthUserController::class, 'resetPassword'])->name('user.password.reset');
        Route::get('/verify-email/{token}', [AuthUserController::class, 'verifyEmail'])->name('user.verify.email');
        Route::post('/resend-email', [AuthUserController::class, 'resendVerification'])->name('user.resend.verification');
        Route::middleware('auth:api')->group(function () {
            Route::get('/getaccount', [AuthUserController::class, 'getAccount'])->name('user.getAccount');
            Route::post('/logout', [AuthUserController::class, 'logout'])->name('user.logout');
            Route::delete('/account', [AuthUserController::class, 'deleteAccount'])->name('user.account.delete');    });
});
Route::middleware('api')->prefix('admin')->group(function()  {
        Route::post('/login', [AuthAdminController::class, 'login'])->name('admin.login');
        Route::post('/register', [AuthAdminController::class, 'register'])->name('admin.register');
        Route::post('/logout', [AuthAdminController::class, 'logout'])->name('admin.logout');
        Route::get('/getaccount', [AuthAdminController::class, 'getAccount'])->name('admin.getAccount');
});
Route::apiResource('tracks' , TrackController::class);
Route::apiResource('instructors' , InstructorController::class);
Route::apiResource('courses' , CourseController::class);
Route::apiResource('course-topics' , CourseTopicController::class);
Route::match(['post', 'put', 'patch'], 'tracks/{id}', [TrackController::class, 'update']);
Route::match(['post', 'put', 'patch'], 'instructors/{id}', [InstructorController::class, 'update']);
Route::match(['post', 'put', 'patch'], 'courses/{id}', [CourseController::class, 'update']);