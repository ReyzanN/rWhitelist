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

    public function RemoveBan($BanId){
        $Check = $this->Exist(BanList::class,$BanId);
        if (!$Check) { abort(404); }
        try {
            $Check->delete();
            Session::flash('Success', 'Suppression réussi avec succès');
        }catch (\Exception $e){
            Session::flash('Failure', 'Une erreur est survenue');
        }
        return redirect()->back();
    }

    public function UpdateBan(BanRequest $request){
        $Check = $this->Exist(BanList::class,$request->only('id')['id']);
        if(!$Check) { abort(404); }
        if ($request->validated()){
            try {
                $Check->update($request->only('reason','expiration'));
                Session::flash('Success', 'Le bannissement à été modifié avec succès');
            }catch (\Exception $e){
                Session::flash('Failure','Une erreur est survenue');
            }
        }
        return redirect()->back();
    }
}
