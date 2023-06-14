<?php

namespace App\Models;


class DiscordAuth
{
    /*
     * Client Info
     */
    private string $_Code;
    private string $_ClientId;
    private string $_ClientSecret;
    private string $_GrantType;
    private string $_RedirectURI;
    private string $_Scope;
    /*
     * Payload
     */
    private array $_Payload;
    /*
     * Target Client Info
     */
    private string $_DiscordAccountEmail;
    private string|null $_DiscordAccountAvatar;
    private string $_DiscordAccountId;
    private string $_DiscordAccountUsername;
    private array $_DiscordAccountRole;

    public function __construct(string $Code)
    {
        $this->_Code = $Code;
        $this->_ClientId = env('APP_DISCORD_CLIENT_ID');
        $this->_ClientSecret = env('APP_DISCORD_CLIENT_SECRET');
        $this->_GrantType = env('APP_DISCORD_CLIENT_GRANT_TYPE');
        $this->_RedirectURI = env('APP_DISCORD_CLIENT_REDIRECT_URI');
        $this->_Scope = env('APP_DISCORD_CLIENT_SCOPE');
    }

    private function BuildPayload(): void {
        $this->_Payload = [
            'code' => $this->_Code,
            'client_id' => $this->_ClientId,
            'client_secret' => $this->_ClientSecret,
            'grant_type' => $this->_GrantType,
            'redirect_uri' => $this->_RedirectURI,
            'scope' => $this->_Scope,
        ];
    }

    public function PerformRequest(): bool
    {
        $this->BuildPayload();
        $PayloadStringQuery = http_build_query($this->_Payload);
        $Curl = curl_init();
        curl_setopt($Curl, CURLOPT_URL,env('APP_DISCORD_TOKEN_URL'));
        curl_setopt($Curl, CURLOPT_POST, true);
        curl_setopt($Curl, CURLOPT_POSTFIELDS, $PayloadStringQuery);
        curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($Curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($Curl, CURLOPT_SSL_VERIFYPEER, 0);
        // --
        $CurlResult = curl_exec($Curl);
        $CurlResult =json_decode($CurlResult, true);
        if (!isset($CurlResult['access_token'])) { return false; }
        $AccessToken = $CurlResult['access_token'];
        $Header = array("Authorization: Bearer $AccessToken", "Content-Type: application/x-www-form-urlencoded");
        $DiscordAPITarget = "https://discordapp.com/api/users/@me";
        $CurlClient = curl_init();
        curl_setopt($CurlClient, CURLOPT_HTTPHEADER, $Header);
        curl_setopt($CurlClient, CURLOPT_URL, $DiscordAPITarget);
        curl_setopt($CurlClient, CURLOPT_POST, false);
        curl_setopt($CurlClient, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($CurlClient, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($CurlClient, CURLOPT_SSL_VERIFYPEER, 0);
        $ResultClient = curl_exec($CurlClient);
        $ResultClient = json_decode($ResultClient,true);
        // --
        $this->_DiscordAccountId = $ResultClient['id'];
        $this->_DiscordAccountUsername = $ResultClient['username'];
        $this->_DiscordAccountAvatar = $ResultClient['avatar'];
        $this->_DiscordAccountEmail = $ResultClient['email'];
        if (!$this->ReadUserDiscordRoles()){
            return false;
        }
        return true;
    }

    public static function GiveWhitelistRole(string $UserDiscordID) :void {
        $ServerID = env("APP_DISCORD_SERVER_ID");
        $TargetRole = env("APP_DISCORD_TARGET_ROLE");
        $DiscordAPITarget = "https://discordapp.com/api/guilds/$ServerID/members/$UserDiscordID/roles/$TargetRole";
        $CurlGiveRole = curl_init();
        $BotToken = env('APP_DISCORD_TOKEN_BOT');
        $Header = array("Authorization: Bot $BotToken", "Content-Type: application/x-www-form-urlencoded");
        curl_setopt($CurlGiveRole, CURLOPT_HTTPHEADER, $Header);
        curl_setopt($CurlGiveRole, CURLOPT_URL, $DiscordAPITarget);
        curl_setopt($CurlGiveRole, CURLOPT_PUT, true);
        curl_setopt($CurlGiveRole, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($CurlGiveRole, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($CurlGiveRole, CURLOPT_SSL_VERIFYPEER, 0);
        //--
        $Result = curl_exec($CurlGiveRole);
        $Result = json_decode($Result,true);
    }

    public static function RevokeWhiteListRole(string $UserDiscordID) :void {
        $ServerID = env("APP_DISCORD_SERVER_ID");
        $TargetRole = env("APP_DISCORD_TARGET_ROLE");
        $DiscordAPITarget = "https://discordapp.com/api/guilds/$ServerID/members/$UserDiscordID/roles/$TargetRole";
        $CurlGiveRole = curl_init();
        $BotToken = env('APP_DISCORD_TOKEN_BOT');
        $Header = array("Authorization: Bot $BotToken", "Content-Type: application/x-www-form-urlencoded");
        curl_setopt($CurlGiveRole, CURLOPT_HTTPHEADER, $Header);
        curl_setopt($CurlGiveRole, CURLOPT_URL, $DiscordAPITarget);
        curl_setopt($CurlGiveRole, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($CurlGiveRole, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($CurlGiveRole, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($CurlGiveRole, CURLOPT_SSL_VERIFYPEER, 0);
        //--
        curl_exec($CurlGiveRole);
    }

    private function ReadUserDiscordRoles() : bool
    {
        $ServerID = env("APP_DISCORD_SERVER_ID");
        $DiscordAPITarget = "https://discordapp.com/api/guilds/$ServerID/members/$this->_DiscordAccountId";
        $CurlGiveRole = curl_init();
        $BotToken = env('APP_DISCORD_TOKEN_BOT');
        $Header = array("Authorization: Bot $BotToken", "Content-Type: application/x-www-form-urlencoded");
        curl_setopt($CurlGiveRole, CURLOPT_HTTPHEADER, $Header);
        curl_setopt($CurlGiveRole, CURLOPT_URL, $DiscordAPITarget);
        curl_setopt($CurlGiveRole, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($CurlGiveRole, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($CurlGiveRole, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($CurlGiveRole, CURLOPT_SSL_VERIFYPEER, 0);
        //--
        $Result = curl_exec($CurlGiveRole);
        $Result = json_decode($Result);
        if (!property_exists($Result,'roles')){ return false; }
        dd($Result);
        $this->_DiscordAccountRole = $Result->roles;
        return true;
    }

    /*
     * Getter for Target Information
     */
    public function getDiscordEmail() :string {
        return $this->_DiscordAccountEmail;
    }
    public function getDiscordUsername() :string {
        return $this->_DiscordAccountUsername;
    }
    public function getDiscordAvatar() :string|null {
        return $this->_DiscordAccountAvatar;
    }
    public function getDiscordId() :string {
        return $this->_DiscordAccountId;
    }
    public function getDiscordRoles() : array {
        return $this->_DiscordAccountRole;
    }

    /*
     * API Functions Discord Usage
     */
    public static function AddBanList($UserId,$Reason){
        $ServerID = env("APP_DISCORD_SERVER_ID");
        $DiscordAPITarget = "https://discordapp.com/api/v9/guilds/$ServerID/bans/$UserId";
        $CurlGiveRole = curl_init();
        $BotToken = env('APP_DISCORD_TOKEN_BOT');
        $Header = array("Authorization: Bot $BotToken", "Content-Type: application/json");
        curl_setopt($CurlGiveRole, CURLOPT_HTTPHEADER, $Header);
        curl_setopt($CurlGiveRole, CURLOPT_URL, $DiscordAPITarget);
        curl_setopt($CurlGiveRole, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($CurlGiveRole, CURLOPT_POSTFIELDS, json_encode(array("reason" => "$Reason")));
        curl_setopt($CurlGiveRole, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($CurlGiveRole, CURLOPT_SSL_VERIFYPEER, 0);
        //--
        $Result = curl_exec($CurlGiveRole);
        curl_close($CurlGiveRole);
    }

    public static function GetAvatar($UserId){
        $ServerID = env("APP_DISCORD_SERVER_ID");
        $DiscordAPITarget = "https://discordapp.com/api/v9/guilds/$ServerID/members/$UserId";
        $CurlAvatar = curl_init();
        $BotToken = env('APP_DISCORD_TOKEN_BOT');
        $Header = array("Authorization: Bot $BotToken", "Content-Type: application/json");
        curl_setopt($CurlAvatar, CURLOPT_HTTPHEADER, $Header);
        curl_setopt($CurlAvatar, CURLOPT_URL, $DiscordAPITarget);
        curl_setopt($CurlAvatar, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($CurlAvatar, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($CurlAvatar, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($CurlAvatar, CURLOPT_SSL_VERIFYPEER, 0);
        //--
        $Result = curl_exec($CurlAvatar);
        $Result = json_decode($Result);
        if (property_exists($Result,'user')){
            if (property_exists($Result->user,'avatar')){
                return $Result->user->avatar;
            }
        }
        return "";
    }
}
