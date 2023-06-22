<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConnectionLog extends Model
{
    use HasFactory;

    protected $table = "connection_logs";

    protected $fillable = [
        'discordAccountId',
        'ip',
        'result'
    ];

    /*
     * Function
     */
    public static function CreateElement(array $Element){
        $DiscordWebHook = new DiscordWebhookMessage(env('APP_DISCORD_WEBHOOK_CONNECTION'));
        try {
            $DiscordWebHook->SendConnectionWebHook($Element[1],$Element[0],$Element[2]);
            return ConnectionLog::create([
                'discordAccountId' => $Element[0],
                'ip' => $Element[1],
                'result' => $Element[2]
            ]);
        }catch (\Exception $e){
            return false;
        }
    }
}
