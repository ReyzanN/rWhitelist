<?php

namespace App\Http\Controllers;

use App\Http\Requests\SessionRegistrationForCandidateRequest;
use App\Models\RecruitmentSession;
use App\Models\RecruitmentSessionCandidateRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RecruitmentSessionCandidateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function __invoke(){
        $Session = RecruitmentSession::GetActiveSessionNotBegan();
        return view('public.sessions.index', ['Session' => $Session]);
    }

    public function UnRegisterForSession($IdSession){
        if (RecruitmentSession::UserCanUnRegisterForSessionStatic($IdSession)){
            $Session = RecruitmentSessionCandidateRegistration::where(['idUser' => auth()->user()->id, 'idSession' => $IdSession]);
            if (!$Session){ abort(404); }
            try {
                $Session->delete();
                Session::flash('Success', 'Vous êtes dé-inscrit');
            }catch (\Exception $e){
                Session::flash('Failure', 'Une erreur est survenue');
            }
        }else{
            Session::flash('Failure','Vous ne pouvez plus vous dé-inscrire');
        }
        return redirect()->back();
    }

    public function RegisterForSession(SessionRegistrationForCandidateRequest $request){
       if (!auth()->user()->CanApplyForAppointment()){
           Session::flash('Failure','Vous ne pouvez pas vous inscrire !');
           return redirect()->back();
       }
       if ($request->validated()){
           $SessionIsActive = RecruitmentSession::SessionIsActive($request->only('idSession')['idSession']);
           if (!$SessionIsActive){
               Session::flash('Failure','Cette session n\'est pas disponible');
               return redirect()->back();
           }
           if ($SessionIsActive->SessionIsFull() || $SessionIsActive->hasBegin()){
               Session::flash('Failure','Cette session est complète, ou à commencée');
               return redirect()->back();
           }
           try {
               RecruitmentSessionCandidateRegistration::create([
                   'idUser' => auth()->user()->id,
                   'idSession' => $request->only('idSession')['idSession'],
                   'backgroundURL' => $request->only('backgroundURL')['backgroundURL']
               ]);
               Session::flash('Success','Vous êtes inscrits');
           }catch (\Exception $e){
               Session::flash('Failure','Une erreur est survenue');
           }
       }
       return redirect()->back();
    }
}
