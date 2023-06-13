<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecruitmentSessionRequest;
use App\Models\DiscordAuth;
use App\Models\DiscordWebhookMessage;
use App\Models\RecruitmentSession;
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
}
