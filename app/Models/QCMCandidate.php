<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QCMCandidate extends Model
{
    use HasFactory, tools;

    protected $table = "qcmcandidate";

    protected $fillable = [
        "idUser",
        "active"
    ];

    /*
     * References
     */
    public function user(){
        return $this->hasOne(User::class,'id','idUser')->get()->first();
    }

    public function QCMAnswer(){
        return $this->hasMany(QCMCandidateAnswer::class,'idQCMCandidate','id')->get();
    }

    public static function GetActiveQCMForAuthUser(){
        return QCMCandidate::where(['idUser' => auth()->user()->id, 'active' => 1])->get()->first();
    }

    public static function GetQCMNotActiveNotMarkedForAuthUser(){
        return QCMCandidate::where(['idUser' => auth()->user()->id,'graded' => 0])->get();
    }

    /*
     * Functions
     */
    public static function createQCMForCandidate(){
        $QCMCandidate = QCMCandidate::create([
            'idUser' => auth()->user()->id,
            'active' => 1,
            'graded' => 0
        ]);
        $QCMQuestionList = QuestionFirstChance::getActiveQuestions();
        $CountQuestion = count($QCMQuestionList);
        $QCMQuestionForCandidate = array();
        /*
         * Randomize number
         */
        do{
            $RandomNumber = random_int(0,$CountQuestion-1);
            if (!in_array($RandomNumber,$QCMQuestionForCandidate)){
                $QCMQuestionForCandidate[] = $RandomNumber;
            }
        }while(count($QCMQuestionForCandidate) < env('APP_WHITELIST_QCM_QUESTION'));
        /*
         * Sort Questions
         */
        foreach ($QCMQuestionForCandidate as $Key => $Value){
            $QCMQuestionForCandidate[$Key] = $QCMQuestionList[$Value];
        }
        foreach ($QCMQuestionForCandidate as $Question){
            QCMCandidateAnswer::create([
                'idQCMCandidate' => $QCMCandidate->id,
                'idQuestion' => $Question->id,
                'answer' => "",
                'status' => 0
            ]);
        }
        return $QCMQuestionForCandidate = QCMCandidateAnswer::where(['idQCMCandidate' => $QCMCandidate->id])->get();
    }

    public function GetNoteForQCM(): int
    {
        Return count(QCMCandidateAnswer::where(['idQCMCandidate' => $this->id, 'status' => 1])->get());
    }
}
