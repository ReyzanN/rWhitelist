<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateNoteRequest;
use App\Models\ActionLog;
use App\Models\DiscordAuth;
use App\Models\User;
use App\Models\UserRank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CandidateManagementController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','recruiters']);
    }

    public function RecruitersCandidateManagementIndex(){
        $Candidate = User::all();
        $WlCount = User::GetCountWl();
        return view('recruiters.candidate.index', ['Candidate' => $Candidate,'WlCount' => $WlCount]);
    }

    public function ForceWhiteList($DiscordIDAccount): \Illuminate\Http\RedirectResponse
    {
        $User = User::findByDiscord($DiscordIDAccount);
        try {
            DiscordAuth::GiveWhitelistRole($DiscordIDAccount);
            UserRank::create([
                'userId' => $User->id,
                'roleId' => env('APP_DISCORD_WL')
            ]);
            ActionLog::createElement(array('CandidateManagementController',5,1,$User));
            Session::flash('Success','Grade ajouté');
        }catch (\Exception $e){
            ActionLog::createElement(array('CandidateManagementController',5,0,$User));
            Session::flash('Failure','Une erreur est survenue');
        }
        return redirect()->back();
    }

    public function RemoveWhiteList($DiscordIDAccount): \Illuminate\Http\RedirectResponse
    {
        $User = User::findByDiscord($DiscordIDAccount);
        try {
            DiscordAuth::RevokeWhiteListRole($DiscordIDAccount);
            $UserRank = UserRank::where(['userId' => $User->id, 'roleId' => env('APP_DISCORD_WL')])->get()->first();
            if ($UserRank) {
                $UserRank->delete();
            }
            ActionLog::createElement(array('CandidateManagementController',6,1,$User));
            Session::flash('Success','Grade supprimé');
        }catch (\Exception $e){
            ActionLog::createElement(array('CandidateManagementController',6,0,$User));
            Session::flash('Failure','Une erreur est survenue');
        }
        return redirect()->back();
    }

    public function ForceQCM($UserAccountId): \Illuminate\Http\RedirectResponse
    {
        $Check = $this->Exist(User::class, $UserAccountId);
        if (!$Check) {
            abort(404);
        }
        try {
            $Check->update(['qcm' => 1]);
            ActionLog::createElement(array('CandidateManagementController',7,1,$Check));
            Session::flash('Success', 'Validation du QCM réussie');
        }catch (\Exception $e){
            ActionLog::createElement(array('CandidateManagementController',7,0,$Check));
            Session::flash('Failure', 'Une erreur est survenue');
        }
        return redirect()->back();
    }

    public function RemoveQCM($UserAccountId): \Illuminate\Http\RedirectResponse
    {
        $Check = $this->Exist(User::class, $UserAccountId);
        if (!$Check) {
            abort(404);
        }
        try {
            $Check->update(['qcm' => 0]);
            ActionLog::createElement(array('CandidateManagementController',8,1,$Check));
            Session::flash('Success', 'Suppression du QCM réussie');
        }catch (\Exception $e){
            ActionLog::createElement(array('CandidateManagementController',8,0,$Check));
            Session::flash('Failure', 'Une erreur est survenue');
        }
        return redirect()->back();
    }

    public function ForceAppointment($UserAccountId): \Illuminate\Http\RedirectResponse
    {
        $Check = $this->Exist(User::class, $UserAccountId);
        if (!$Check) {
            abort(404);
        }
        try {
            $Check->update(['appointment' => 1]);
            ActionLog::createElement(array('CandidateManagementController',9,1,$Check));
            Session::flash('Success', 'Validation de l\'entretient réussie');
        }catch (\Exception $e){
            ActionLog::createElement(array('CandidateManagementController',9,0,$Check));
            Session::flash('Failure', 'Une erreur est survenue');
        }
        return redirect()->back();
    }

    public function RemoveAppointment($UserAccountId){
        $Check = $this->Exist(User::class, $UserAccountId);
        if (!$Check) {
            abort(404);
        }
        try {
            $Check->update(['appointment' => 0]);
            ActionLog::createElement(array('CandidateManagementController',10,1,$Check));
            Session::flash('Success', 'Suppression de l\'entretient réussie');
        }catch (\Exception $e){
            ActionLog::createElement(array('CandidateManagementController',10,0,$Check));
            Session::flash('Failure', 'Une erreur est survenue');
        }
        return redirect()->back();
    }

    public function UpdateNote(CandidateNoteRequest $request)
    {
        $Check = $this->Exist(User::class, $request->only('id')['id']);
        if (!$Check) {
            abort(404);
        }
        if ($request->validated()) {
            try {
                $Check->update(['note' => $request->only('note')['note']]);
                ActionLog::createElement(array('CandidateManagementController',11,1,$Check));
                Session::flash('Success', 'Note ajoutée');
            } catch (\Exception $e) {
                ActionLog::createElement(array('CandidateManagementController',11,0,$Check));
                Session::flash('Failure', 'Une erreur est survenue');
            }
        }
        return redirect()->back();
    }

    /*
     * AJAX
     */
    public function RecruitersCandidateManagementViewCandidate(Request $request){
        $Check = $this->Exist(User::class,$request->only('data')['data']);
        if (!$Check){
            abort('404');
        }
        return view('recruiters.candidate.modalViewCandidate', ['Candidate' => $Check]);
    }
}
