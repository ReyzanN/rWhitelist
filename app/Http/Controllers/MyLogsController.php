<?php

namespace App\Http\Controllers;

use App\Models\ActionLog;
use App\Models\AuthRoutingLog;
use App\Models\ConnectionLog;
use App\Models\GuestRoutingLog;
use App\Models\User;
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

    public function ViewConnectionLogs(){
        $ConnectionLogs = ConnectionLog::all();
        return view('admin.logs.ConnectionLog', ['ConnectionLogs' => $ConnectionLogs]);
    }

    public function ViewAllLogsAction(){
        $ActionLogs = ActionLog::all();
        return view('admin.logs.ActionLog', ['ActionLog' => $ActionLogs]);
    }

    public function SeeUserLogs(Request $request){
        $UserDiscordId = $request->only('discordAccountId');
        $User = User::findByDiscord($UserDiscordId['discordAccountId']);
        if (!$User){
            ActionLog::createElement(array('MyLogsController',23,0));
            Session::flash('Failure', 'Cet utilisateur n\'existe pas');
            return redirect()->back();
        }
        ActionLog::createElement(array('MyLogsController',23,1));
        return view('admin.logs.UserLogSee', ['User' => $User]);
    }

    public function ClearRoutingLogs() {
        try {
            AuthRoutingLog::Clear();
            GuestRoutingLog::Clear();
            ActionLog::createElement(array('MyLogsController',4,1));
            Session::flash('Success','Log Routing Supprimé');
        }catch (\Exception $e){
            ActionLog::createElement(array('MyLogsController',4,0));
            Session::flash('Failure','Une erreur est survenue');
        }
        return redirect()->back();
    }
}
