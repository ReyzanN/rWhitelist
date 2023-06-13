<?php

namespace App\Models;

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

}
