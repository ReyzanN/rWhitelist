<?php

namespace App\Http\Controllers;

use App\Models\QCMCandidate;
use App\Models\QCMCandidateAnswer;
use App\Models\QuestionFirstChance;
use http\Exception\BadConversionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QCMCandidateController extends Controller
{
    public function __construct(){
        $this->middleware(['auth']);
    }

    public function __invoke(){
        if (auth()->user()->qcm == 1){
            Session::flash('Failure','Vous avez déjà réussi le QCM !');
            return redirect()->back();
        }
        $CanDoQCM = auth()->user()->CanApplyForQCM();
        $Chance = auth()->user()->GetChanceForQCM();
        $Attempt = auth()->user()->GetAttemptForQCM();

        return view('public.qcm.index',['CanDoQCM' => $CanDoQCM,'QCMChance' => $Chance,'Attempt' => $Attempt]);
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
        return view('public.qcm.ajaxModalContentQCM',['QuestionsList' => $QuestionsList]);
    }
}
