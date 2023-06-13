<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentSession extends Model
{
    use HasFactory, tools;

    /*
     * Table
     */
    protected $table = "recruitment_sessions";

    /*
     * Fillable
     */
    protected $fillable = [
        'maxCandidate',
        'SessionDate',
        'theme',
        'active',
        'created_by',
        'closed_by'
    ];

    /*
     * References
     */
    public function GetClosedByUser() : User {
       return $this->hasOne(User::class,'id','closed_by')->get()->first();
    }

    public function GetCreatedBy(): User {
        return $this->hasOne(User::class,'id','created_by')->get()->first();
    }

    public function GetCandidateRegistration() :Collection {
        return $this->hasMany(RecruitmentSessionCandidateRegistration::class,'idSession','id')->get();
    }

    public function GetRecruitersRegistration(): Collection {
        return $this->hasMany(RecruitmentSessionRecruiterRegistration::class,'idSession','id')->get();
    }
    /*
     * Functions
     */
    public static function GetActiveSession(): Collection {
        return RecruitmentSession::where(['active' => 1])->get();
    }

    public function GetCountRegistrationCandidate(): int
    {
        return count($this->GetCandidateRegistration());
    }

    public function GetCountRegistrationRecruiters(): int {
        return count($this->GetRecruitersRegistration());
    }

    public function RecruitersIsRegisteredForSession($IdRecruiter): bool
    {
        foreach ($this->GetRecruitersRegistration() as $Registration){
            if ($Registration->idUser == $IdRecruiter){
                return true;
            }
        }
        return false;
    }

    public static function SessionIsActive($Id){
        $Check = RecruitmentSession::where(['id' => $Id,'active'=> 1])->get()->first();
        if (!$Check) { return false; }
        return $Check;
    }

}
