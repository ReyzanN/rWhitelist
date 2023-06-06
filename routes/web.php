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
            Route::post('/recruiters/qcm/question/type/add', [QCMController::class, 'addQuestionType'])->name('qcm.questionType.add');
            Route::get('/recruiters/qcm/question/type/remove/{QuestionTypeId}', [QCMController::class, 'removeQuestionType'])->name('qcm.questionType.remove');
            Route::post('/recruiters/qcm/question/type/update', [QCMController::class, 'updateQuestionType'])->name('qcm.questionType.update');
            /*
             * Question First Chance
             */
            Route::post('/recruiters/qcm/question/firstChance/add',[QCMController::class, 'addQuestionFirstChance'])->name('qcm.questionFirstChance.add');
            Route::get('/recruiters/qcm/question/firstChance/remove/{QuestionID}', [QCMController::class, 'removeQuestionFirstChance'])->name('qcm.questionFirstChance.remove');
            Route::post('/recruiters/qcm/question/firstChance/update', [QCMController::class, 'updateQuestionFirstChance'])->name('qcm.questionFirstChance.update');

            /*
             * API - AJAX
             */
            Route::post('/recruiters/qcm/question/type/update/ajax', [QCMController::class, 'SearchQuestionTypeID'])->name('qcm.questionType.ajax.update');
            Route::post('/recruiters/qcm/question/update/ajax', [QCMController::class, 'SearchQuestionFirstChanceID'])->name('qcm.questionFirstChance.ajax.update');
    });
});
