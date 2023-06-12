<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class BanList extends Model
{
    use HasFactory, tools;

    protected $table = "banlist";

    protected $fillable = [
        "discordAccountId",
        "reason",
        "expiration"
    ];

    /*
     * Functions
     */
    public static function isBanned($DiscordAccountID) :bool {
        $Check = BanList::where('discordAccountId', '=' ,$DiscordAccountID)->where('expiration', '>',new \DateTime())->orderBy('id','desc')->get()->first();
        if ($Check) { return true;};
        return false;
    }

    public static function GetBanForUser($DiscordAccountID): bool|BanList {
        $Check = BanList::where(['discordAccountId' => $DiscordAccountID])->get();
        if ($Check) { return $Check;}
        return false;
    }

    public static function GetLastBanForUser($DiscordAccountID): bool|BanList {
        $Check = BanList::where('discordAccountId', '=' ,$DiscordAccountID)->where('expiration', '>',new \DateTime())->orderBy('id','desc')->get()->first();
        if ($Check) { return $Check;}
        return false;
    }
}
