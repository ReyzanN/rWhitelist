<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QCMCandidateAnswer extends Model
{
    use HasFactory, tools;

    protected $table = "qcmcandidateanswer";


    protected $fillable = [
        'idQCMCandidate',
        'idQuestion',
        'answer',
        'status'
    ];

    /*
     * References
     */
    public function QCMCandidate(){
        return $this->hasOne(QCMCandidate::class,'id','idQCMCandidate')->get()->first();
    }

    public function Question(){
        return $this->hasOne(QuestionFirstChance::class,'id','idQuestion')->get()->first();
    }
}
