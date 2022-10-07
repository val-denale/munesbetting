<?php

use App\Http\Controllers\Admin\PredictionsController as AdminPredictionsController;
use App\Http\Controllers\Admin\SportsController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\Userscontroller;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Predictions\PredictionController;
use App\Http\Controllers\Subscriptions\PlanController;
use App\Http\Controllers\Subscriptions\StripeIntentController;
use App\Http\Controllers\Subscriptions\SubscriptionController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorSecretKeyController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });

});

Route::middleware('admin')->group(function () {
    Route::post('/admin/prediction/store', [AdminPredictionsController::class, 'store']);
    Route::get('/admin/predictions', [AdminPredictionsController::class, 'index']);
    Route::get('/admin/prediction/{id}', [AdminPredictionsController::class, 'show']);
    Route::patch('/admin/prediction/{id}', [AdminPredictionsController::class, 'update']);
    Route::get('/admin/sports', [SportsController::class, 'index']);
    Route::get('/admin/stats', [StatsController::class, 'index']);
    Route::get('/admin/users', [Userscontroller::class, 'index']);
    Route::get('/admin/user/{id}', [Userscontroller::class, 'show']);
    Route::post('/admin/user/{id}/createSubscription', [Userscontroller::class, 'createSubscription']);
});

Route::get('/plans', [PlanController::class, 'index']);
Route::get('/plan/{slug}', [PlanController::class, 'show']);

Route::get('/predictions', [PredictionController::class, 'index']);
Route::get('/last-predictions', [PredictionController::class, 'lastPrediction']);
Route::post('/subscriptions', [SubscriptionController::class, 'store']);

Route::get('/subscriptions/intent', StripeIntentController::class);
Route::patch('/subscriptions', [SubscriptionController::class, 'update']);
Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel']);
Route::get('/subscription/invoices', [SubscriptionController::class, 'invoices']);

Route::post('/contact', [ContactController::class, 'send']);
