<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecruitmentSessionRequest;
use App\Models\DiscordAuth;
use App\Models\DiscordWebhookMessage;
use App\Models\RecruitmentSession;
use App\Models\RecruitmentSessionCandidateRegistration;
use App\Models\RecruitmentSessionRecruiterRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RecruitmentSessionsController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','recruiters']);
    }

    /*
     * Functions
     */
    public function __invoke(){
        $ActiveSession = RecruitmentSession::GetActiveSession();
        foreach ($ActiveSession as $Session){
            $Session->RecruitersList = $Session->GetRecruitersRegistration();
            foreach ($Session->RecruitersList as $Recruiter){
                $Recruiter->avatar = DiscordAuth::GetAvatar($Recruiter->GetUser()->discordAccountId);
            }
        }
        return view('recruiters.session.index',['ActiveSession' => $ActiveSession]);
    }

    public function AddSession(RecruitmentSessionRequest $request): \Illuminate\Http\RedirectResponse
    {
        if ($request->validated()){
            $SessionDate = $request->only('SessionDate')['SessionDate'];
            $MaxCandidate = $request->only('maxCandidate')['maxCandidate'];
            $Theme = $request->only('theme')['theme'];
            if (!$Theme){
                $Theme = "Aucun";
            }
            try {
                $Session = RecruitmentSession::create([
                    'maxCandidate' => $MaxCandidate,
                    'SessionDate' => $SessionDate,
                    'theme' => $Theme,
                    'active' => 1,
                    'created_by' => auth()->user()->id
                ]);
                $DiscordWebHook = new DiscordWebhookMessage(env('APP_WEB_HOOK_SESSION_URL'));
                $DiscordWebHook->SendWebhookRecruitementSession($Session->parseDateToString($Session->SessionDate),$Session->maxCandidate,$Session->theme,auth()->user()->discordUserName);
                Session::flash('Success','Création de la session réussie');
            }catch (\Exception $e){
                Session::flash('Failure','Une erreur est survenue');
            }
        }
        return redirect()->back();
    }

    public function ViewSession($IdSession){
        $Session = RecruitmentSession::SessionIsActive($IdSession);
        if (!$Session){ abort('404'); }
        $RecruitersForSession = $Session->GetRecruitersRegistration();
        foreach ($RecruitersForSession as $ReS){
            $ReS->avatar = DiscordAuth::GetAvatar($ReS->GetUser()->discordAccountId);
        }
        return view('recruiters.session.viewSession',['SessionInformation' => $Session,'Recruiters' => $RecruitersForSession]);
    }

    /*
     * Recruiters
     */
    public function RegisterRecruitersForSession($IdSession){
        $Check = RecruitmentSession::SessionIsActive($IdSession);
        if (!$Check) { abort(404); }
        try {
            RecruitmentSessionRecruiterRegistration::create([
                'idUser' => auth()->user()->id,
                'idSession' => $Check->id
            ]);
            Session::flash('Success','Vous êtes inscrits, merci !');
        }catch (\Exception $e){
            Session::flash('Failure','Une erreur est survenue');
        }
        return redirect()->back();
    }

    public function RemoveRegistrationRecruitersForSession($IdSession){
        $Check = RecruitmentSession::SessionIsActive($IdSession);
        if (!$Check) { abort(404); }
        try {
            $Registration = RecruitmentSessionRecruiterRegistration::where(['idUser' => auth()->user()->id,'idSession' => $Check->id]);
            $Registration->delete();
            Session::flash('Success','Vous n\'êtes plus inscrits');
        }catch (\Exception $e){
            Session::flash('Failure','Une erreur est survenue');
        }
        return redirect()->back();
    }

    public function ViewCandidate(Request $request){
        $Check = $this->Exist(User::class,$request->only('data')['data']);
        if (!$Check){
            abort('404');
        }
        return view('recruiters.session.modalContentCandidate', ['Candidate' => $Check]);
    }

    public function TerminateSession($IdSession): \Illuminate\Http\RedirectResponse
    {
        $Check = RecruitmentSession::SessionIsActive($IdSession);
        if (!$Check) { abort(404); }
        $CandidateForSession = $Check->GetCandidateRegistration();
        try {
            foreach ($CandidateForSession as $Candidate){
                if ($Candidate->result == null){
                    $Candidate->update([
                        'present' => 0,
                        'result' => 0
                    ]);
                }
            }
            $Check->update([
                'active' => 0,
                'closed_by' => auth()->user()->id
            ]);
            Session::flash('Success','La session à été fermée avec succès');
        }catch (\Exception $e){
            Session::flash('Failure','Une erreur est survenue');
        }
        return redirect()->route('recruiters.sessions.view');
    }

    /*
     * Call Candidate Ajax
     */
    public function CallCandidateSpecific(Request $request){
        $DiscordWebhook = new DiscordWebhookMessage(env('APP_WEB_HOOK_SESSION_URL'));
        $DiscordWebhook->SendWebhookCallCandidate($request->only('data')['data']);
        return view('recruiters.session.customMessage');
    }

    public function CallCandidateSpecificAll(Request $request){
        $Check = RecruitmentSession::SessionIsActive($request->only('data')['data']);
        if (!$Check) { abort(404); }
        $SessionCandidate = $Check->GetCandidateRegistration();
        $AccountToPing = array();
        foreach ($SessionCandidate as $Candidate){
            $AccountToPing[] = $Candidate->GetUser()->discordAccountId;
        }
        $DiscordWebhook = new DiscordWebhookMessage(env('APP_WEB_HOOK_SESSION_URL'));
        $DiscordWebhook->SendWebhookCallCandidateAll($AccountToPing);
        return view('recruiters.session.customMessage');
    }

    /*
     * Appointment Outcome
     */

    public function ValidatedAppointment($IdSession,$IdUser): \Illuminate\Http\RedirectResponse
    {
        $CandidateAppointment = RecruitmentSessionCandidateRegistration::where(['idSession' => $IdSession, 'idUser' => $IdUser])->get()->first();
        if (!$CandidateAppointment) { abort(404); }
        if ($CandidateAppointment->result){ abort(404); }
        try {
            $CandidateAppointment->update([
                'validatedBy' => auth()->user()->id,
                'present' => 1,
                'result' => 1
            ]);
            $User = User::find($CandidateAppointment->idUser);
            $User->update([
               'appointment' => 1
            ]);
            DiscordAuth::GiveWhitelistRole($User->discordAccountId);
            Session::flash('Success','Candidature validée');
        }catch (\Exception $e){
            Session::flash('Failure','Une erreur est survenue');
        }
        return redirect()->back();
    }

    public function RefusedAppointment($IdSession,$IdUser): \Illuminate\Http\RedirectResponse
    {
        $CandidateAppointment = RecruitmentSessionCandidateRegistration::where(['idSession' => $IdSession, 'idUser' => $IdUser])->get()->first();
        if (!$CandidateAppointment) { abort(404); }
        if ($CandidateAppointment->result){ abort(404); }
        try {
            $CandidateAppointment->update([
                'validatedBy' => auth()->user()->id,
                'present' => 1,
                'result' => 2
            ]);
            Session::flash('Success','Candidature refusée');
        }catch (\Exception $e){
            Session::flash('Failure','Une erreur est survenue');
        }
        return redirect()->back();
    }

    public function RefusedPermanentAppointment($IdSession,$IdUser): \Illuminate\Http\RedirectResponse
    {
        $CandidateAppointment = RecruitmentSessionCandidateRegistration::where(['idSession' => $IdSession, 'idUser' => $IdUser])->get()->first();
        if (!$CandidateAppointment) { abort(404); }
        if ($CandidateAppointment->result){ abort(404); }
        try {
            $CandidateAppointment->update([
                'validatedBy' => auth()->user()->id,
                'present' => 1,
                'result' => 3
            ]);
            Session::flash('Success','Candidature refusée de façon permanante');
        }catch (\Exception $e){
            Session::flash('Failure','Une erreur est survenue');
        }
        return redirect()->back();
    }

}
