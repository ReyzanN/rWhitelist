<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionFirstChanceRequest;
use App\Http\Requests\QuestionTypeRequest;
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
                QuestionType::create([
                    'title' => $request->only('label')['label'],
                    'active' => 1
                ]);
                Session::flash('Success','Ajouté avec succès');
            }catch (\Exception $e){
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
            $Check->delete();
            Session::flash('Success', 'Suppression réussie');
        }catch (\Exception $e){
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
                $QT->update([
                    'title' => $request->only('label')['label'],
                    'active' =>  $request->only('active')['active']
                ]);
                Session::flash('Success','Modification réalisée avec succès');
            }catch (\Exception $e){
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
                QuestionFirstChance::create([
                    'question' => $request->only('question')['question'],
                    'answer' => $request->only('answer')['answer'],
                    'idTypeQuestion' => $request->only('idTypeQuestion')['idTypeQuestion'],
                    'active' => 1
                ]);
                Session::flash('Success', 'Ajout de question réussi');
            }catch (\Exception $e){
                // Silence is golden
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
            $Check->delete();
            Session::flash('Success','Suppression de question réussi');
        }catch (\Exception $e){
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
                $Question->update([
                    'question' => $request->only('question')['question'],
                    'answer' => $request->only('answer')['answer'],
                    'idTypeQuestion' => $request->only('idTypeQuestion')['idTypeQuestion'],
                    'active' => $request->only('active')['active']
                ]);
                Session::flash('Success','Modification réalisée avec succès');
            }catch (\Exception $e){
                // Silence is golden
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
        return view('recruiters.qcm.modalUpdateType',['QT' => $Check]);
    }

    public function SearchQuestionFirstChanceID(Request $request){
        $Check = $this->Exist(QuestionFirstChance::class,$request->only('data')['data']);
        if (!$Check) {
            abort(404);
        }
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
            return view('recruiters.qcm.correctionForm', ['QCM' => $QCM, 'QuestionsList' => $QCM->QCMAnswer()]);
        }
        return redirect()->back();
    }

    public function UpdateCorrectionQCMCandidate($IdQCM,$QuestionID,$Params){
        $Question = QCMCandidateAnswer::where(['idQCMCandidate' => $IdQCM, 'id' => $QuestionID])->get()->first();
        if (!$Question){
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
        return redirect()->back();
    }

    public function UpdateFinalQCM($IdQCM){
        $QCM = QCMCandidate::find($IdQCM);
        if (!$QCM){
            Session::flash('Failure','Ce questionnaire n\'appartient à personne');
        }
        try {
            $QCM->update(['graded' => 1, 'gradedBy' => auth()->user()->id]);
            $Grade = $QCM->GetNoteForQCM();
            if ($Grade >= env('APP_WHITELIST_QCM_SCORE_MINI')){
                $QCM->user()->update(['qcm' => 1]);
            }
            Session::flash('Success','Merci ! C\'est enregistré !');
        }catch (\Exception $e){
            //
        }
        return redirect()->route('qcm.correction');
    }
}
