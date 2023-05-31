<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePublicController extends Controller
{
    public function __invoke(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        if (auth()->user()) {
            return redirect()->route('dashPublic.index');
        }
        return view('public/auth/index');
    }
}
