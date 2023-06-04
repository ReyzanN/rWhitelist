<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionTypeRequest;
use App\Models\QuestionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QCMController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','recruiters']);
    }

    public function index(){
        return view('recruiters.qcm.index', ['QuestionType' => QuestionType::getActiveTypes()]);
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

    /*
     * public function removeQuestionType
     */
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
}
