<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardPublicController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function __invoke(){
        return view('public.dashboard.index');
    }

    public function viewProfile(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('public.dashboard.profile');
    }
}
