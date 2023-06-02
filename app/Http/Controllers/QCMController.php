<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QCMController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','recruiters']);
    }

    public function index(){
        return view('recruiters.qcm.index');
    }
}
