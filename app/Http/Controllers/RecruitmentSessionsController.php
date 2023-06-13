<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecruitmentSessionRequest;
use App\Models\DiscordWebhookMessage;
use App\Models\RecruitmentSession;
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
}
