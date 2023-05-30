<?php

namespace App\Http\Controllers;

use App\Models\DiscordAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\NoReturn;
use function mysql_xdevapi\getSession;

class AuthController extends Controller
{
    #[NoReturn] public function Login(): void
    {
        header('location: '.env('APP_DISCORD_URL'));
        exit();
    }

    public function TryLogin(){
        $DiscordAuth = new DiscordAuth($_GET['code']);
        if (!$DiscordAuth->PerformRequest()) {
            return redirect()->route('auth.login');
        }
        $ClientInfo = array(
            'Email' => $DiscordAuth->getDiscordEmail(),
            'DiscordUserName' => $DiscordAuth->getDiscordUsername(),
            'Avatar' => $DiscordAuth->getDiscordAvatar(),
            'DiscordId' => $DiscordAuth->getDiscordId(),
            'DiscordRole' => $DiscordAuth->getDiscordRoles()
        );
        if (!User::checkAccount($ClientInfo['DiscordId'])){
            try {
                User::create([
                    'discordAccountId' => $ClientInfo['DiscordId'],
                    'discordUserName' => $ClientInfo['DiscordUserName'],
                    'discordEmail' => $ClientInfo['Email'],
                    'lastConnection' => new \DateTime(),
                ]);
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
                $auth = true;
            }
        }catch (\Exception $e){
            // Silence is golden
        }
        if ($auth){
            // Redirect dashboard
            auth()->user()->avatar = $ClientInfo['Avatar'];
            return redirect()->route('dashPublic.index');
        }
        // Add error message
        return redirect()->route('base');
    }

    public function Logout(){
        auth()->logout();
        return redirect()->route('base');
    }
}
