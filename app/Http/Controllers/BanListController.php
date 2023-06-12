<?php

namespace App\Http\Controllers;

use App\Http\Requests\BanRequest;
use App\Models\BanList;
use App\Models\DiscordAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

    public function AddBan(BanRequest $request){
        if ($request->validated()){
            try {
                $CheckUser = User::findByDiscord($request->only('discordAccountId')['discordAccountId']);
                if ($CheckUser){
                    $CheckUser->update(['killSession' => 1]);
                }
                BanList::create([
                    'discordAccountId' => $request->only('discordAccountId')['discordAccountId'],
                    'reason' => $request->only('reason')['reason'],
                    'expiration' => $request->only('expiration')['expiration']
                ]);
                Session::flash('Success','Bannissement effectué');
            }catch (\Exception $e){
                Session::flash('Failure', 'Une erreur est survenue');
            }
            return redirect()->back();
        }
    }
}
