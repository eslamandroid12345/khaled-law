<?php

use App\Http\Controllers\Api\V1\Chat\ChatController;
use App\Http\Controllers\Api\V1\Auth\Otp\OtpController;
use App\Http\Controllers\Api\V1\Appointment\AppointmentController;
use App\Http\Controllers\Api\V1\Attachment\AttachmentController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Category\CategoryController;
use App\Http\Controllers\Api\V1\Consultation\ConsultationController;
use App\Http\Controllers\Api\V1\Home\HomeController;
use App\Http\Controllers\Api\V1\Lawyer\LawyerController;
use App\Http\Controllers\Api\V1\LegalForm\LegalFormController;
use App\Http\Controllers\Api\V1\Order\OrderController;
use App\Http\Controllers\Api\V1\Review\ReviewController;
use App\Http\Controllers\Api\V1\Service\ServiceController;
use App\Http\Controllers\Api\V1\Structure\HeaderFooterController;
use App\Http\Controllers\Api\V1\Time\TimeController;
use App\Http\Controllers\Api\V1\Transaction\TransactionController;
use App\Http\Controllers\Api\V1\Update\UpdatesController;
use App\Http\Controllers\Api\V1\User\UserController;
use App\Http\Controllers\Api\V1\Social\SocialController;
use App\Http\Controllers\Api\V1\CustomerReview\CustomerReviewController;

use App\Http\Controllers\Api\V1\Uses\UsesController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'controller' => AuthController::class], function () {
    Route::group(['prefix' => 'sign'], function () {
        Route::post('in', 'signIn');
        Route::post('up', 'signUp');
        Route::post('out', 'signOut')->middleware('auth:api');
    });


    Route::post('/reset', [AuthController::class, 'reset']);
    Route::post('/reset-confirm', [AuthController::class, 'resetUserconfirm']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    Route::get('what-is-my-platform', 'whatIsMyPlatform'); // returns 'platform: website!'
});
Route::group(['prefix' => 'otp', 'middleware' => ['auth:api']], function () {
    Route::post('/verify', [OtpController::class, 'verify']);
    Route::get('/', [OtpController::class, 'send']);
});

Route::group(['prefix' => 'auth/login', 'controller' => SocialController::class], function () {
    Route::get('{provider}', 'redirect');
    Route::get('{provider}/callback', 'callback');
});

Route::group(['prefix' => 'profile', 'controller' => UserController::class], function () {
    Route::get('details', 'getDetails');
    Route::get('user/{id}/details', 'getUserDetails')->middleware('type:LAWYER');
    Route::get('payments', 'getPayments');
    Route::post('update', 'updateMainData');
    Route::post('update/password', 'changePassword');
});

Route::group(['prefix' => 'consultation', 'controller' => ConsultationController::class], function () {
    Route::get('{id}/cancel', 'cancelConsultation');
    Route::post('/', 'store');
});

Route::group(['prefix' => 'legalforms', 'controller' => LegalFormController::class], function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
});

Route::get('/legal-forms/user', [LegalFormController::class,'getAllLegaFormForUser'])->middleware('type:USER');
Route::prefix('services')->controller(ServiceController::class)->group(function () {
    Route::get('/', 'index');
});
Route::prefix('categories')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'index');
});


Route::group(['prefix' => 'consultation', 'controller' => ConsultationController::class], function () {
    Route::post('/', 'store');
    Route::get('/', 'index')->middleware('type:USER');
    Route::get('/lawyer', 'indexLawyer')->middleware('type:LAWYER');
    Route::get('/{id}', 'show');
    Route::get('get-price/{id}', 'getPrice');
    Route::post('/update/{id}', 'updateDate')->middleware('type:LAWYER');
    Route::get('/cancel/{id}', 'cancel')->middleware('type:LAWYER');
});

Route::group(['prefix' => 'transactions', 'controller' => TransactionController::class], function () {
    Route::post('/consultation', 'storeConsultation');
    Route::post('/legalForm', 'storeLegalForm');
});

Route::group(['prefix' => 'legalforms', 'controller' => LegalFormController::class], function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::get('/download/{id}', 'download');

    Route::post('/store-order', 'storeOrder');
    Route::get('/store-order/{id}', 'getOrder');

    Route::get('/get-my-legal-form', 'myLegalForms');
});

Route::group(['prefix' => 'lawyers', 'controller' => LawyerController::class], function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
});

Route::prefix('services')->controller(ServiceController::class)->group(function () {
    Route::get('/{id}', 'show');
    Route::get('/{id}/breadcrumb', 'breadcrumb');
    Route::get('/', 'index');
});
Route::prefix('orders')->middleware('auth:api')->controller(OrderController::class)->group(function () {
    Route::post('/review', 'storeReview');
    Route::get('/{id}', 'show');
    Route::post('/', 'store');
    Route::get('/', 'index');
});

Route::prefix('times')->controller(TimeController::class)->group(function () {
    Route::get('/', 'index');
});

Route::prefix('attachments')->middleware('auth:api')->controller(AttachmentController::class)->group(function () {
    Route::post('/', 'store');
});
Route::prefix('updates')->middleware('auth:api')->controller(UpdatesController::class)->group(function () {
    Route::post('/', 'store');
});
Route::prefix('appointments')->middleware('auth:api')->controller(AppointmentController::class)->group(function () {
    Route::post('/', 'store');
});

Route::prefix('customer-reviews')->controller(CustomerReviewController::class)->group(function () {
    Route::get('/', 'index');
});

Route::prefix('uses')->controller(UsesController::class)->group(function () {
    Route::get('/', 'index');
});

Route::prefix('reviews')->controller(ReviewController::class)->group(function () {
    Route::get('/user', 'index');
});

Route::prefix('home')->controller(HomeController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/search', 'search');
});

Route::get('header-footer', HeaderFooterController::class);

Route::prefix('categories')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'index');
});
Route::group(['prefix' => 'chats', 'controller' => ChatController::class], function () {
    Route::group(['prefix' => 'rooms'], function () {
        Route::group(['prefix' => '{room:id}'], function () {
            Route::get('/', 'getMessages');
            Route::post('load', 'loadMoreMessages');
            Route::post('send', 'send');
            Route::put('read', 'read');
        });
    });
});
Route::prefix('lawyer')->middleware('auth:api')->controller(UserController::class)->group(function () {
    Route::get('/appointments', 'getMyAppointments');
    Route::get('/home', 'getLawyerHome');
});
