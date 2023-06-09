<?php

namespace App\Http\Controllers;

use App\Models\BanList;
use Illuminate\Http\Request;

class BanListController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','recruiters']);
    }

    public function DisplayBanList(){
        $BanList = BanList::all();
        $BanCount = count($BanList);
        return view('recruiters.banlist.view',['BanList' => $BanList, 'BanCount' => $BanCount]);
    }
}
