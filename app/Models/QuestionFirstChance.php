<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionFirstChance extends Model
{
    use HasFactory, tools;

    protected $table = "question_first_chance";

    protected $fillable = [
        'question',
        'answer',
        'active',
        'idTypeQuestion'
    ];

    /*
     * Foreign Key
     */
    public function QuestionType(){
        return $this->hasOne(QuestionType::class,'id','idTypeQuestion')->get()->first();
    }

    /*
     * Functions
     */
    public static function getActiveQuestions(){
        return QuestionFirstChance::where(['active' => 1])->get();
    }
}
