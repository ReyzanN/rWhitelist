<?php

namespace App\Http\Controllers;

use App\Models\BanList;
use App\Models\ConnectionLog;
use App\Models\DiscordAuth;
use App\Models\User;
use App\Models\UserRank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use JetBrains\PhpStorm\NoReturn;

class AuthController extends Controller
{
    #[NoReturn] public function Login(): void
    {
        header('location: '.env('APP_DISCORD_URL'));
        exit();
    }

    public function TryLogin(Request $request){
        $DiscordAuth = new DiscordAuth($_GET['code']);
        if (!$DiscordAuth->PerformRequest()) {
            Session::flash('Failure','Vous n\'êtes pas sur le discord');
            return redirect()->route('base');
        }
        $ClientInfo = array(
            'Email' => $DiscordAuth->getDiscordEmail(),
            'DiscordUserName' => $DiscordAuth->getDiscordUsername(),
            'Avatar' => $DiscordAuth->getDiscordAvatar(),
            'DiscordId' => $DiscordAuth->getDiscordId(),
            'DiscordRole' => $DiscordAuth->getDiscordRoles()
        );
        if (!BanList::isBanned($DiscordAuth->getDiscordId())){
            if (!User::checkAccount($ClientInfo['DiscordId'])){
                try {
                    $TempUser = User::create([
                        'discordAccountId' => $ClientInfo['DiscordId'],
                        'discordUserName' => $ClientInfo['DiscordUserName'],
                        'discordEmail' => $ClientInfo['Email'],
                        'lastConnection' => new \DateTime(),
                    ]);
                    foreach ($ClientInfo['DiscordRole'] as $Role){
                        UserRank::create([
                            'userId' => $TempUser->id,
                            'roleId' => $Role
                        ]);
                    }
                }catch (\Exception $e){
                    // Silence is golden
                }
            }
            try {
                $auth = false;
                $User = User::findByDiscord($ClientInfo['DiscordId']);
                if ($User){
                    Auth::login($User);
                    session()->regenerate();
                    $User->updateLastConnection();
                    $User->updateRole($ClientInfo['DiscordRole']);
                    $auth = true;
                }
            }catch (\Exception $e){
                //
            }
            if ($auth){
                // Redirect dashboard
                auth()->user()->avatar = $ClientInfo['Avatar'];
                ConnectionLog::CreateElement(array($ClientInfo['DiscordId'],$request->ip(),1));
                return redirect()->route('dashPublic.index');
            }
        }
        $Ban = BanList::GetLastBanForUser($DiscordAuth->getDiscordId());
        if ($Ban){
            Session::flash('Failure', 'Vous êtes banni pour la raison suivante : '.$Ban->reason.' - Expiration : '.$Ban->parseDateToString($Ban->expiration));
        }
        ConnectionLog::CreateElement(array($ClientInfo['DiscordId'],$request->ip(),0));
        // Add error message
        return redirect()->route('base');
    }

    public function Logout(){
        auth()->logout();
        return redirect()->route('base');
    }
}
