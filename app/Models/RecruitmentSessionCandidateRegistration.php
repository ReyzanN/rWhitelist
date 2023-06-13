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

}
