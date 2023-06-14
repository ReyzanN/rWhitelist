<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateNoteRequest;
use App\Models\DiscordAuth;
use App\Models\User;
use App\Models\UserRank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use MongoDB\Driver\Exception\ExecutionTimeoutException;

class CandidateManagementController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','recruiters']);
    }

    public function RecruitersCandidateManagementIndex(){
        $Candidate = User::all();
        return view('recruiters.candidate.index', ['Candidate' => $Candidate]);
    }

    public function ForceWhiteList($DiscordIDAccount): \Illuminate\Http\RedirectResponse
    {
        try {
            DiscordAuth::GiveWhitelistRole($DiscordIDAccount);
            $User = User::findByDiscord($DiscordIDAccount);
            UserRank::create([
                'userId' => $User->id,
                'roleId' => env('APP_DISCORD_WL')
            ]);
            Session::flash('Success','Grade ajouté');
        }catch (\Exception $e){
            Session::flash('Failure','Une erreur est survenue');
        }
        return redirect()->back();
    }

    public function RemoveWhiteList($DiscordIDAccount): \Illuminate\Http\RedirectResponse
    {
        try {
            DiscordAuth::RevokeWhiteListRole($DiscordIDAccount);
            $User = User::findByDiscord($DiscordIDAccount);
            $UserRank = UserRank::where(['userId' => $User->id, 'roleId' => env('APP_DISCORD_WL')])->get()->first();
            if ($UserRank) {
                $UserRank->delete();
            }
            Session::flash('Success','Grade supprimé');
        }catch (\Exception $e){
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
            Session::flash('Success', 'Validation du QCM réussie');
        }catch (\Exception $e){
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
            Session::flash('Success', 'Suppression du QCM réussie');
        }catch (\Exception $e){
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
            Session::flash('Success', 'Validation de l\'entretient réussie');
        }catch (\Exception $e){
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
            Session::flash('Success', 'Suppression de l\'entretient réussie');
        }catch (\Exception $e){
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
                Session::flash('Success', 'Note ajoutée');
            } catch (\Exception $e) {
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
