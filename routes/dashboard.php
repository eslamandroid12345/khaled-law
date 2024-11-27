<?php

use App\Http\Controllers\Dashboard\Appointment\AppointmentController;
use App\Http\Controllers\Dashboard\Attachment\AttachmentController;
use App\Http\Controllers\Dashboard\Auth\AuthController;
use App\Http\Controllers\Dashboard\Category\CategoryController;
use App\Http\Controllers\Dashboard\Consultation\ConsultationController;
use App\Http\Controllers\Dashboard\CustomerReview\CustomerReviewController;
use App\Http\Controllers\Dashboard\Home\HomeController;
use App\Http\Controllers\Dashboard\Info\InfoController;
use App\Http\Controllers\Dashboard\LegalForm\LegalFormController;
use App\Http\Controllers\Dashboard\Mangers\MangerController;
use App\Http\Controllers\Dashboard\Payment\PaymentController;
use App\Http\Controllers\Dashboard\Question\QuestionController;
use App\Http\Controllers\Dashboard\Roles\RoleController;
use App\Http\Controllers\Dashboard\Service\ServiceController;
use App\Http\Controllers\Dashboard\Settings\SettingController;
use App\Http\Controllers\Dashboard\Structure\HeaderFooterController;
use App\Http\Controllers\Dashboard\Structure\HomeStructureController;
use App\Http\Controllers\Dashboard\Structure\InfoStructureController;
use App\Http\Controllers\Dashboard\Transaction\TransactionController;
use App\Http\Controllers\Dashboard\Update\UpdateController;
use App\Http\Controllers\Dashboard\Time\TimeController;
use App\Http\Controllers\Dashboard\User\UserController;
use App\Http\Controllers\Dashboard\Lawyer\LawyersController;
use App\Http\Controllers\Dashboard\Uses\UsesController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Order\OrderController;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
], function () {
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', [AuthController::class, '_login'])->name('_login');

        Route::post('login', [AuthController::class, 'login'])->name('login');

        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', [HomeController::class, 'index'])->name('/');
        Route::resource('users', UserController::class);
        Route::post('users/toggle', [UserController::class, 'toggle'])->name('toggleUser');
    });
    Route::resource('settings', SettingController::class)->only('edit', 'update');
    Route::post('update-password', [SettingController::class, 'updatePassword'])->name('update-password');
    Route::resource('roles', RoleController::class);
    Route::get('role/{id}/managers', [RoleController::class, 'mangers'])->name('roles.mangers');
    Route::resource('managers', MangerController::class)->except('show', 'index');

    Route::resource('lawyers', LawyersController::class);
    Route::post('lawyers/toggle', [LawyersController::class, 'toggle'])->name('toggleLawyer');

    Route::resource('legal-forms', LegalFormController::class);
    Route::post('legal-forms/toggle', [LegalFormController::class, 'toggle'])->name('togglelegalforms');

    Route::resource('customer-reviews', CustomerReviewController::class);
    Route::resource('consultations', ConsultationController::class);
    Route::get('consultations/setLawyer/{id}', [ConsultationController::class,'setLawyer'])->name('consultation.setLawyer');

    Route::resource('time',TimeController::class);
    Route::post('times/active',[TimeController::class ,'toggleTime'])->name('times.toggle');

    Route::resource('uses',UsesController::class);
    Route::resource('transactions',TransactionController::class);

    Route::resource('categories', CategoryController::class);
    Route::get('service/{id}/questions/create', [QuestionController::class,'create'])->name('questions.create');
    Route::get('service/{id}/questions', [QuestionController::class,'index'])->name('questions.index');
    Route::resource('questions', QuestionController::class)->except('create','index');
    Route::resource('services', ServiceController::class);
    Route::get('orders/{order}/chat', [OrderController::class, 'chat'])->name('order.chat');
    Route::put('orders/{order}/status', [OrderController::class, 'changeStatus'])->name('order.status.update');
    Route::put('orders/{order}/lawyer', [OrderController::class, 'changeLawyer'])->name('order.lawyer.update');
    Route::post('orders/{order}/attachment', [AttachmentController::class, 'store'])->name('attachments.store');
    Route::post('orders/{order}/update', [UpdateController::class, 'store'])->name('updates.store');
    Route::post('orders/{order}/appointment', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::post('orders/{order}/payment', [PaymentController::class, 'store'])->name('payments.store');
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'destroy']);
    Route::delete('attachments/{id}', [AttachmentController::class, 'destroy'])->name('dashboard.attachments.destroy');
    Route::delete('payments/{id}', [PaymentController::class, 'destroy'])->name('dashboard.payments.destroy');
    Route::delete('updates/{id}', [UpdateController::class, 'destroy'])->name('dashboard.updates.destroy');
    Route::delete('appointments/{id}', [AppointmentController::class, 'destroy'])->name('dashboard.appointments.destroy');

    Route::group(['prefix' => 'structures'], function () {
        Route::resource('home-content', HomeStructureController::class)->only(['index', 'store']);
        Route::resource('header-footer', HeaderFooterController::class)->only(['index', 'store']);
    });

    Route::get('infos/edit',[InfoController::class,'edit'])->name('infos.edit');
    Route::post('infos/update',[InfoController::class,'update'])->name('infos.update');

});
