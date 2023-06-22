<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionFirstChanceRequest;
use App\Http\Requests\QuestionTypeRequest;
use App\Models\ActionLog;
use App\Models\QCMCandidate;
use App\Models\QCMCandidateAnswer;
use App\Models\QuestionFirstChance;
use App\Models\QuestionType;
use http\Exception\BadConversionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QCMController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','recruiters']);
    }

    public function index(){
        $Question = QuestionFirstChance::all();
        $QuestionCount = count(QuestionFirstChance::getActiveQuestions());
        return view('recruiters.qcm.index', ['QuestionType' => QuestionType::all(),'QuestionTypeActive' => QuestionType::getActiveTypes(),'Question' => $Question, 'QuestionCount' => $QuestionCount]);
    }

    /*
     * Question Type
     */
    public function addQuestionType(QuestionTypeRequest $request){
        if ($request->validated()){
            try {
                $QT = QuestionType::create([
                    'title' => $request->only('label')['label'],
                    'active' => 1
                ]);
                ActionLog::createElement(array('QCMQuestionType',2,1,$QT));
                Session::flash('Success','Ajouté avec succès');
            }catch (\Exception $e){
                ActionLog::createElement(array('QCMQuestionType',2,0));
                Session::flash('Failure','Une erreur est survenue');
            }
        }
        return redirect()->back();
    }

    public function removeQuestionType($QuestionTypeId){
        $Check = $this->Exist(QuestionType::class,$QuestionTypeId);
        if (!$Check){
            abort(404);
        }
        try {
            ActionLog::createElement(array('QCMQuestionType',4,1,$Check));
            $Check->delete();
            Session::flash('Success', 'Suppression réussie');
        }catch (\Exception $e){
            ActionLog::createElement(array('QCMQuestionType',4,0,$Check));
            Session::flash('Failure', 'Une erreur est survenue');
        }
        return redirect()->back();
    }

    public function updateQuestionType(QuestionTypeRequest $request){
        if ($request->validated()){
            $QT = QuestionType::find($request->only('id')['id']);
            if(!$QT){
                abort(404);
            }
            try {
                ActionLog::createElement(array('QCMQuestionType',3,1,$QT));
                $QT->update([
                    'title' => $request->only('label')['label'],
                    'active' =>  $request->only('active')['active']
                ]);
                Session::flash('Success','Modification réalisée avec succès');
            }catch (\Exception $e){
                ActionLog::createElement(array('QCMQuestionType',3,0,$QT));
                Session::flash('Failure','Une erreur est survenue');
            }
        }
        return back();
    }

    /*
     * Question First Chance
     */
    public function addQuestionFirstChance(QuestionFirstChanceRequest $request){
        if ($request->validated()){
            try {
                $QTF = QuestionFirstChance::create([
                    'question' => $request->only('question')['question'],
                    'answer' => $request->only('answer')['answer'],
                    'idTypeQuestion' => $request->only('idTypeQuestion')['idTypeQuestion'],
                    'active' => 1
                ]);
                ActionLog::createElement(array('QCMQuestion',2,1,$QTF));
                Session::flash('Success', 'Ajout de question réussi');
            }catch (\Exception $e){
                // Silence is golden
                ActionLog::createElement(array('QCMQuestion',2,0));
                Session::flash('Failure', 'Une erreur est survenue');
            }
        }
        return redirect()->back();
    }

    public function removeQuestionFirstChance($QuestionId){
        $Check = $this->Exist(QuestionFirstChance::class,$QuestionId);
        if (!$Check){
            abort(404);
        }
        try {
            ActionLog::createElement(array('QCMQuestion',4,1,$Check));
            $Check->delete();
            Session::flash('Success','Suppression de question réussi');
        }catch (\Exception $e){
            ActionLog::createElement(array('QCMQuestion',4,0,$Check));
            Session::flash('Failure', 'Une erreur est survenue');
        }
        return redirect()->back();
    }

    public function updateQuestionFirstChance(QuestionFirstChanceRequest $request){
        if ($request->validated()){
            $Question = QuestionFirstChance::find($request->only(['id']))->first();
            if (!$Question) {
                abort(404);
            }
            try {
                ActionLog::createElement(array('QCMQuestion',3,1,$Question));
                $Question->update([
                    'question' => $request->only('question')['question'],
                    'answer' => $request->only('answer')['answer'],
                    'idTypeQuestion' => $request->only('idTypeQuestion')['idTypeQuestion'],
                    'active' => $request->only('active')['active']
                ]);
                Session::flash('Success','Modification réalisée avec succès');
            }catch (\Exception $e){
                // Silence is golden
                ActionLog::createElement(array('QCMQuestion',3,0,$Question));
                Session::flash('Failure','Une erreur est survenue');
            }
        }
        return back();
    }

    /*
     * AJAX
     */
    public function SearchQuestionTypeID(Request $request){
        $Check = $this->Exist(QuestionType::class,$request->only('data')['data']);
        if (!$Check) {
            abort(404);
        }
        ActionLog::createElement(array('QCMQuestion',1,1,$Check));
        return view('recruiters.qcm.modalUpdateType',['QT' => $Check]);
    }

    public function SearchQuestionFirstChanceID(Request $request){
        $Check = $this->Exist(QuestionFirstChance::class,$request->only('data')['data']);
        if (!$Check) {
            abort(404);
        }
        ActionLog::createElement(array('QCMQuestion',1,1,$Check));
        return view('recruiters.qcm.modalUpdateQuestionFirstChance',['Q' => $Check,'QuestionTypeActive' => QuestionType::getActiveTypes()]);
    }

    /*
     * QCM First Chance Correction
     */
    public function getQCMCorrectionPending(){
        $QCMPending = QCMCandidate::GetQCMWaitingCorrection();
        $PendingCount = count($QCMPending);
        return view('recruiters.qcm.correction', ['QCMCandidate' => $QCMPending,'QCMPendingCount' => $PendingCount]);
    }

    /*
     * Ajax
     */
    public function SearchToBeginCorrection($IdQCM){
        $QCM = QCMCandidate::QCMIsPendingAndNotMarked($IdQCM);
        if ($QCM){
            ActionLog::createElement(array('QCMQuestion',22,1,$QCM));
            return view('recruiters.qcm.correctionForm', ['QCM' => $QCM, 'QuestionsList' => $QCM->QCMAnswer()]);
        }
        $CheckQCMMarked = QCMCandidate::find($IdQCM);
        if ($CheckQCMMarked){
            ActionLog::createElement(array('QCMQuestion',16,1,$CheckQCMMarked));
            return view('recruiters.qcm.correctionFormView', ['QCM' => $CheckQCMMarked, 'QuestionsList' => $CheckQCMMarked->QCMAnswer()]);
        }
        return redirect()->back();
    }

    public function UpdateCorrectionQCMCandidate($IdQCM,$QuestionID,$Params){
        /*
         * Fix Bypass QCM already marked
         */
        $QCM = QCMCandidate::QCMIsPendingAndNotMarked($IdQCM);
        if (!$QCM) {
            ActionLog::createElement(array('QCMQuestion',18,0,$QCM));
            abort(404);
        }
        $Question = QCMCandidateAnswer::where(['idQCMCandidate' => $IdQCM, 'id' => $QuestionID])->get()->first();
        if (!$Question){
            ActionLog::createElement(array('QCMQuestion',19,0,$QCM));
            Session::flash('Failure','Cette question n\'est pas lié à ce candidat');
        }
        try {
            switch ($Params){
                case 1:
                    $Question->update(['status' => 1]);
                    Session::flash('Success','Réponse enregistrée : Vous avez validé sa réponse');
                    break;
                case 0:
                    $Question->update(['status' => 0]);
                    Session::flash('Success','Réponse enregistrée : Vous avez refusé sa réponse');
                    break;
                default:
                    Session::flash('Failure','Une erreur est survenue');
                    break;
            }
        }catch (\Exception $e){
            //
        }
        ActionLog::createElement(array('QCMQuestion',15,1,$Question));
        return redirect()->back();
    }

    public function UpdateFinalQCM($IdQCM){
        /*
         * Patch Bypass
         */
        $QCM = QCMCandidate::QCMIsPendingAndNotMarked($IdQCM);
        if (!$QCM){
            ActionLog::createElement(array('QCMQuestion',20,1,$IdQCM));
            Session::flash('Failure','Ce questionnaire n\'appartient à personne');
        }
        try {
            $QCM->update(['graded' => 1, 'gradedBy' => auth()->user()->id]);
            $Grade = $QCM->GetNoteForQCM();
            if ($Grade >= env('APP_WHITELIST_QCM_SCORE_MINI')){
                $QCM->user()->update(['qcm' => 1]);
            }
            ActionLog::createElement(array('QCMQuestion',21,1,$QCM));
            Session::flash('Success','Merci ! C\'est enregistré !');
        }catch (\Exception $e){
            //
        }
        return redirect()->route('qcm.correction');
    }
}
