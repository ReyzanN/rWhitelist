<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CandidateManagementController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','recruiters']);
    }

    public function RecruitersCandidateManagementIndex(){
        $Candidate = User::all();
        return view('recruiters.candidate.index', ['Candidate' => $Candidate]);
    }

    /*
     * AJAX
     */
    public function RecruitersCandidateManagementViewCandidate(Request $request){
        $Check = $this->Exist(User::class,$request->only('data')['data']);
        if (!$Check){
            abort('404');
        }
        return view('recruiters.candidate.modalViewCandidate', ['Candidate' => $Check]);
    }
}
