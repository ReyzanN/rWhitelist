<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BanListController;
use App\Http\Controllers\CandidateManagementController;
use App\Http\Controllers\DashboardPublicController;
use App\Http\Controllers\DashboardRecruitersController;
use App\Http\Controllers\HomePublicController;
use App\Http\Controllers\QCMCandidateController;
use App\Http\Controllers\QCMController;
use App\Http\Controllers\RecruitmentSessionsController;
use App\Http\Controllers\UsersController;
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

Route::middleware(['auth','killSession'])->group(function(){
    /* Dashboard */
    Route::get('/dashboard', DashboardPublicController::class)->name('dashPublic.index');

    /*
     * Profile
     */
    Route::get('/dashboard/myProfile', [DashboardPublicController::class, 'viewProfile'])->name('dashPublic.profile');
    Route::post('/dashboard/myProfile/updateInformations', [UsersController::class,'UpdateInformation'])->name('users.updateInformation');


    /*
     * Candidate QCM
     */
    Route::get('/qcm/candidate',QCMCandidateController::class)->name('qcm.candidate.index');
    Route::post('/qcm/candidate/validate',[QCMCandidateController::class,'ValidateQCM'])->name('qcm.candidate.validate');
        /*
         * Ajax
         */
        Route::post('/qcm/candidate/apply/ajax', [QCMCandidateController::class,'GetQCM'])->name('qcm.candidate.getQCM.ajax');
        Route::post('/qcm/candidate/continue/', [QCMCandidateController::class,'ContinueQCM'])->name('qcm.candidate.continue.ajax');

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
             * QCM Correction
             */
            Route::get('/recruiters/qcm/correction',[QCMController::class, 'getQCMCorrectionPending'])->name('qcm.correction');
            Route::get('/recruiters/qcm/correction/{QCMId}', [QCMController::class, 'SearchToBeginCorrection'])->name('qcm.beginCorrection');
            Route::get('/recruiters/qcm/correction/validateQuestion/{IdQCM}/{IdQuestion}/{Params}', [QCMController::class, 'UpdateCorrectionQCMCandidate'])->name('qcm.correction.validateQuestion');
            Route::get('/recruiters/qcm/correction/validateQuestion/{IdQCM}/', [QCMController::class, 'UpdateFinalQCM'])->name('qcm.correction.validate');

            /*
             * Ajax
             */
            Route::post('/recruiters/qcm/question/type/update/ajax', [QCMController::class, 'SearchQuestionTypeID'])->name('qcm.questionType.ajax.update');
            Route::post('/recruiters/qcm/question/update/ajax', [QCMController::class, 'SearchQuestionFirstChanceID'])->name('qcm.questionFirstChance.ajax.update');

        /*
         * Sessions Management
         */
        Route::get('/recruiters/sessions/', RecruitmentSessionsController::class)->name('recruiters.sessions.view');
        Route::post('/recruiters/sessions/add', [RecruitmentSessionsController::class,'AddSession'])->name('recruiters.sessions.add');

            /*
             * Recruiters Session Register
             */
            Route::get('/recruiters/sessions/register/{IdSession}', [RecruitmentSessionsController::class,'RegisterRecruitersForSession'])->name('recruiters.session.register');
            Route::get('/recruiters/sessions/unregister/{IdSession}', [RecruitmentSessionsController::class,'RemoveRegistrationRecruitersForSession'])->name('recruiters.session.unregister');

        /*
         * Ban List
         */
        Route::get('/recruiters/ban/list/view',[BanListController::class, 'DisplayBanList'])->name('recruiters.banlist.view');
        Route::post('/recruiters/ban/add/', [BanListController::class, 'AddBan'])->name('recruiters.ban.add');
        Route::get('/recruiters/ban/remove/{BanId}', [BanListController::class, 'RemoveBan'])->name('recruiters.ban.remove');
        Route::post('/recruiters/ban/update/', [BanListController::class, 'UpdateBan'])->name('recruiters.ban.update');

        /*
         * Candidate Management
         */
        Route::get('/recruiters/candidate/view/all', [CandidateManagementController::class, 'RecruitersCandidateManagementIndex'])->name('recruiters.candidate.view');
            /*
             * Ajax
             */
            Route::post('/recruiters/candidate/view/', [CandidateManagementController::class, 'RecruitersCandidateManagementViewCandidate'])->name('recruiters.candidate.view.ajax');
            /*
             * Add / Remove Whitelist
             */
            Route::get('/recruiters/candidate/forceWhitelist/{DiscordIDAccount}', [CandidateManagementController::class, 'ForceWhiteList'])->name('recruiters.candidate.force.whitelist');
            Route::get('/recruiters/candidate/removeWhitelist/{DiscordIDAccount}', [CandidateManagementController::class, 'RemoveWhiteList'])->name('recruiters.candidate.remove.whitelist');

            /*
             * Add / Remove QCM
             */
            Route::get('/recruiters/candidate/forceQCM/{UserId}', [CandidateManagementController::class, 'ForceQCM'])->name('recruiters.candidate.force.qcm');
            Route::get('/recruiters/candidate/removeQCM/{UserId}', [CandidateManagementController::class, 'RemoveQCM'])->name('recruiters.candidate.remove.qcm');

            /*
             * Add / Remove Appointment
             */
            Route::get('/recruiters/candidate/forceAppointment/{UserId}', [CandidateManagementController::class, 'ForceAppointment'])->name('recruiters.candidate.force.appointment');
            Route::get('/recruiters/candidate/removeAppointment/{UserId}', [CandidateManagementController::class, 'RemoveAppointment'])->name('recruiters.candidate.remove.appointment');

            /*
             * Update Note
             */
            Route::post('/recruiters/candidate/update/note',[CandidateManagementController::class,'UpdateNote'])->name('recruiters.candidate.update.note');

    });
});
