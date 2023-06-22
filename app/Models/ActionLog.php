<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    use HasFactory;

    protected $table = "action_logs";

    protected $fillable = [
        'discordAccountId',
        'controller',
        'type',
        'result',
        'Element'
    ];

    /*
     * Functions
     */
    public static function GetType($Element) :string {
        return match ($Element) {
            1 => "GET",
            2 => "POST",
            3 => "UPDATE",
            4 => "DELETE",
            default => "error",
        };
    }

    public static function createElement(array $Element){
        if (key_exists(3,$Element)){
            ActionLog::create([
                'discordAccountId' => auth()->user()->discordAccountId,
                'controller' => $Element[0],
                'type' => ActionLog::GetType($Element[1]),
                'result' => $Element[2],
                'Element' => json_encode($Element[3])
            ]);
        }else {
            ActionLog::create([
                'discordAccountId' => auth()->user()->discordAccountId,
                'controller' => $Element[0],
                'type' => ActionLog::GetType($Element[1]),
                'result' => $Element[2]
            ]);
        }
    }
}
