<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardPublicController;
use App\Http\Controllers\DashboardRecruitersController;
use App\Http\Controllers\HomePublicController;
use App\Http\Controllers\QCMController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Base Route */
Route::get('/', HomePublicController::class)->name('base');

/* Auth Route */
Route::get('/login',[AuthController::class, 'Login'])->name('auth.login');
Route::get('/loginValidation', [AuthController::class, 'TryLogin'])->name('auth.trylogin');
Route::get('/logout', [AuthController::class, 'Logout'])->name('auth.logout');

Route::middleware(['auth'])->group(function(){
    /* Dashboard */
    Route::get('/dashboard', DashboardPublicController::class)->name('dashPublic.index');

    /*
     * Recruiters Route
     */
    Route::middleware(['recruiters'])->group(function(){
        /*
         * Dashboard
         */
        Route::get('/dashboard/recruiters', DashboardRecruitersController::class)->name('dashRecruiters.index');
        /*
         * QCM Management
         */
        Route::get('/recruiters/qcm/', [QCMController::class,'index'])->name('qcm.index');
            /*
             * Question Type QCM
             */
            Route::post('/recruiters/qcm/question/add', [QCMController::class, 'addQuestionType'])->name('qcm.question.add');
            Route::get('/recruiters/qcm/question/remove/{QuestionTypeId}', [QCMController::class, 'removeQuestionType'])->name('qcm.question.remove');
            Route::post('/recruiters/qcm/question/update', [QCMController::class, 'updateQuestionType'])->name('qcm.question.update');

            /*
             * API - AJAX
             */
            Route::post('/recruiters/qcm/question/update/ajax', [QCMController::class, 'SearchQuestionTypeID'])->name('qcm.question.ajax.update');
    });
});
