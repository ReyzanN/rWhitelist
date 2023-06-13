<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentSessionRecruiterRegistration extends Model
{
    use HasFactory;

    /*
     * Table
     */
    protected $table = "recruitment_session_recruiter_registration";

    /*
     * Fillable
     */
    protected $fillable = [
        "idSession",
        "idUser"
    ];

    /*
     * References
     */
    public function GetUser(): User {
        return $this->hasOne(User::class,'id','idUser')->get()->first();
    }

    public function GetSession(): RecruitmentSession {
        return $this->hasOne(RecruitmentSession::class, 'id','idSession')->get()->first();
    }
}
