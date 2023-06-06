<?php

namespace App\Http\Controllers;

use App\Http\Requests\QCMCandidateValidateRequest;
use App\Models\QCMCandidate;
use App\Models\QCMCandidateAnswer;
use App\Models\QuestionFirstChance;
use http\Exception\BadConversionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Termwind\Components\Ol;

class QCMCandidateController extends Controller
{
    public function __construct(){
        $this->middleware(['auth']);
    }

    public function __invoke(){
        $CanDoQCM = auth()->user()->CanApplyForQCM();
        $Chance = auth()->user()->GetChanceForQCM();
        $Attempt = auth()->user()->GetAttemptForQCM();
        $OldQCMForCandidate = QCMCandidate::where(['idUser' => auth()->user()->id])->get();
        return view('public.qcm.index',['CanDoQCM' => $CanDoQCM,'QCMChance' => $Chance,'Attempt' => $Attempt,'OldQCM' => $OldQCMForCandidate]);
    }

    /*
     * QCMValidation
     */
    public function ValidateQCM(QCMCandidateValidateRequest $request){
        if ($request->validated()){
            $CandidateAnswer = $request->only('answer')['answer'];
            $QCMID = QCMCandidate::GetActiveQCMForAuthUser();
            if ($QCMID->active) {
                foreach ($CandidateAnswer as $Key => $Value) {
                    $TempAnswer = QCMCandidateAnswer::where(['idQCMCandidate' => $QCMID->id, 'id' => $Key])->get()->first();
                    if ($TempAnswer) {
                        $TempAnswer->update(['answer' => $Value]);
                    }
                }
                Session::flash('Success', 'Merci les recruteurs vont étudier vos réponses.');
                $QCMID->update(['active' => 0]);
                return redirect()->back();
            }
            Session::flash('Failure','Vous avez déjà envoyé ce questionnaire');
            return redirect()->back();
        }
    }

    /*
     * Ajax QCM
     */
    public function GetQCM(){
        if (!auth()->user()->CanApplyForQCM()){
            $Message = "... t'es chances sont épuisé c'est marqué pourtant...";
            return view('public.qcm.errorPage',['Error' => $Message]);
        }
        $QuestionsList = QCMCandidate::createQCMForCandidate();
        $QCM = $QuestionsList[0]->QCMCandidate();
        return view('public.qcm.ajaxModalContentQCM',['QuestionsList' => $QuestionsList, 'QCM' => $QCM]);
    }

    public function ContinueQCM(Request $request){
        $QCM = QCMCandidate::where(['idUser' => auth()->user()->id, 'id' => $request->only('data')['data']])->get()->first();
        if (!$QCM){
            return view('public.qcm.errorPage',['Error' => 'Tu n\'as rien à foutre la']);
        }
        if (!$QCM->active) { return view('public.qcm.errorPage',['Error' => 'Tu n\'as rien à foutre la']); }
        $QCMQuestion = $QCM->QCMAnswer();
        $QCM = $QCMQuestion[0]->QCMCandidate();
        return view('public.qcm.ajaxModalContentQCM',['QuestionsList' => $QCMQuestion, 'QCM' => $QCM]);
    }
}
