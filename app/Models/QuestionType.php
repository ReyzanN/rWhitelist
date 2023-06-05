<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    use HasFactory, tools;

    protected $table = "qcmquestiontype";

    protected $fillable = [
      "title",
      "active"
    ];

    /*
     * Question First Type Link
     */
    public function getQuestionFirstChance(){
        return $this->hasMany(QuestionFirstChance::class,'idTypeQuestion','id')->get();
    }

    /*
     * functions
     */
    public static function getActiveTypes(){
        return QuestionType::where(['active' => 1])->get();
    }
}
