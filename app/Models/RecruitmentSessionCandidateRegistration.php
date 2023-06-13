<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentSessionCandidateRegistration extends Model
{
    use HasFactory;

    /*
     * Table
     */
    protected $table = "recruitment_session_candidate_registration";

    /*
     * Fillable
     */
    protected $fillable = [
        "idUser",
        "idSession",
        "validatedBy",
        "backgroundURL",
        "present",
        "result"
    ];

    /*
     * References
     */
    public function GetSession(): RecruitmentSession {
        return $this->hasOne(RecruitmentSession::class,'id','idSession')->get()->first();
    }

    public function GetValidatedBy(): User|null {
        return $this->hasOne(User::class,'id','validatedBy')->get()->first();
    }

    public function GetUser(): User {
        return $this->hasOne(User::class,'id','idUser')->get()->first();
    }

    /*
     * Functions
     */

    public function GetResultForSessionWebhook(): string
    {
        switch ($this->result){
            case 1:
                return "Validé";
                break;
            case 2:
                return "Refusé";
                break;
            case 3:
                return "Refus définitif";
                break;
            default:
                return "Oula Problème";
                break;
        }
    }

    public static function GetValidatedApplication($IdSession){
        return RecruitmentSessionCandidateRegistration::where(['idSession' => $IdSession,'result' => 1])->get();
    }

    public static function GetCountValidatedUsers($IdSession){
        return count(RecruitmentSessionCandidateRegistration::where(['idSession' => $IdSession,'result' => 1])->get());
    }

    public static function GetDeniedApplication($IdSession){
        return RecruitmentSessionCandidateRegistration::where(['idSession' => $IdSession,'result' => 2])->get();
    }

    public static function GetPermaDeniedApplication($IdSession){
        return RecruitmentSessionCandidateRegistration::where(['idSession' => $IdSession,'result' => 3])->get();
    }

}
