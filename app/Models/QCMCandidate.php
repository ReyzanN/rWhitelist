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
        return $this->hasMany(QCMCandidateAnswer::class,'idQCMCandidate','id');
    }

    /*
     * Functions
     */
    public static function createQCMForCandidate(){
        $QCMCandidate = QCMCandidate::create([
            'idUser' => auth()->user()->id,
            'active' => 1,
            'graded' => 1
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
}
