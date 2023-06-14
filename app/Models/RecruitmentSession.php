<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

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

    public static function GetActiveSessionNotBegan() : Collection
    {
        return RecruitmentSession::where(['active' => 1])->where('SessionDate', '>' ,new \DateTime())->get();
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

    public function SessionIsFull():bool {
        if ($this->GetCountRegistrationCandidate() >= $this->maxCandidate) { return true; }
        return false;
    }

    public function hasBegin():bool {
        $DateSession = new \DateTime($this->SessionDate);
        $DateNow = new \DateTime();
        if ($DateNow > $DateSession){ return true; }
        return false;
    }

    public static function SessionIsActive($Id)
    {
        $Check = RecruitmentSession::where(['id' => $Id, 'active' => 1])->get()->first();
        if (!$Check) {
            return false;
        }
        return $Check;
    }

    public function GetArrayForRecapWebhook(int $IdSession){
        $FieldList = array();

        $Temp = new \stdClass();
        $Temp->name = "Candidat Accepté";
        $Temp->value = $this->GetCandidateValidatedForWebHook($IdSession);
        $Temp->inline = false;

        $FieldList[] = $Temp;

        $Temp = new \stdClass();
        $Temp->name = "Candidat Refusé";
        $Temp->value = $this->GetCandidateRefusedForWebHook($IdSession);
        $Temp->inline = false;

        $FieldList[] = $Temp;

        $Temp = new \stdClass();
        $Temp->name = "Candidat Refusé définitivement";
        $Temp->value = $this->GetCandidateRefusedPermanentForWebHook($IdSession);
        $Temp->inline = false;

        $FieldList[] = $Temp;

        $Temp = new \stdClass();
        $Temp->name = "Statistique";
        $Temp->value = "Nombre de candidat accepté :".RecruitmentSessionCandidateRegistration::GetCountValidatedUsers($IdSession);
        $Temp->inline = false;

        $FieldList[] = $Temp;

        return $FieldList;
    }

    public function GetCandidateValidatedForWebHook(int $IdSession): string{
        $ValidatedApplication = RecruitmentSessionCandidateRegistration::GetValidatedApplication($IdSession);
        $String = "";

        foreach ($ValidatedApplication as $Application){
            $String .= "<@".$Application->GetUser()->discordAccountId.">";
        }
        return $String;
    }

    public function GetCandidateRefusedForWebHook(int $IdSession): string{
        $ValidatedApplication = RecruitmentSessionCandidateRegistration::GetDeniedApplication($IdSession);
        $String = "";

        foreach ($ValidatedApplication as $Application){
            $String .= "<@".$Application->GetUser()->discordAccountId.">";
        }
        return $String;
    }

    public function GetCandidateRefusedPermanentForWebHook(int $IdSession): string{
        $ValidatedApplication = RecruitmentSessionCandidateRegistration::GetPermaDeniedApplication($IdSession);
        $String = "";

        foreach ($ValidatedApplication as $Application){
            $String .= "<@".$Application->GetUser()->discordAccountId.">";
        }
        return $String;
    }

    public static function UserCanUnRegisterForSessionStatic($IdSession): bool
    {
        $Session = RecruitmentSession::SessionIsActive($IdSession);
        if (!$Session) { abort(404); }
        $DateMinus2Hour = date('Y-m-d H:i:s', strtotime($Session->SessionDate.' - 2 hour'));
        $DateMinus2Hour = new \DateTime($DateMinus2Hour);
        if (new \DateTime() > $DateMinus2Hour){
            return false;
        }
        return true;
    }

    public function UserCanUnRegisterForSession(): bool
    {
        $Session = RecruitmentSession::SessionIsActive($this->id);
        if (!$Session) { return false; }
        $DateMinus2Hour = date('Y-m-d H:i:s', strtotime($Session->SessionDate.' - 2 hour'));
        $DateMinus2Hour = new \DateTime($DateMinus2Hour);
        if (new \DateTime() > $DateMinus2Hour){
            return false;
        }
        return true;
    }

}
