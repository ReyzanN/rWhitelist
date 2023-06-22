<?php

namespace App\Http\Controllers;

use App\Models\AuthRoutingLog;
use App\Models\GuestRoutingLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MyLogsController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','MyLogs']);
    }

    public function __invoke(){
        return view('admin.logs.index');
    }

    public function ViewAuthRoutingLogs(){
        $AuthRoutingLog = AuthRoutingLog::all();
        return view('admin.logs.AuthRoutingLog', ['AuthRoutingLog' => $AuthRoutingLog]);
    }

    public function ViewGuestRoutingLogs(){
        $GuestLog = GuestRoutingLog::all();
        return view('admin.logs.GuestRoutingLog', ['GuestRoutingLog' => $GuestLog]);
    }

    public function ClearRoutingLogs() {
        try {
            AuthRoutingLog::Clear();
            GuestRoutingLog::Clear();
            Session::flash('Success','Log Routing Supprimé');
        }catch (\Exception $e){
            Session::flash('Failure','Une erreur est survenue');
        }
        return redirect()->back();
    }
}
