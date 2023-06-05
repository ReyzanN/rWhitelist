<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionFirstChanceRequest;
use App\Http\Requests\QuestionTypeRequest;
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
        return view('recruiters.qcm.index', ['QuestionType' => QuestionType::all(),'QuestionTypeActive' => QuestionType::getActiveTypes(),'Question' => $Question]);
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

    /*
     * AJAX
     */
    public function SearchQuestionTypeID(Request $request){
        $Check = $this->Exist(QuestionType::class,$request->only('data')['data']);
        if (!$Check){
            abort(404);
        }
        return view('recruiters.qcm.modalUpdateType',['QT' => $Check]);
    }
}
