<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthRoutingLog extends Model
{
    use HasFactory;

    protected $table = "auth_logs_routing";

    protected $fillable = [
        'discordAccountId',
        'url',
        'ip'
    ];

    /*
     * Functions
     */

    public static function Clear(){
        foreach (AuthRoutingLog::all() as $Element){
            $Element->delete();
        }
    }
}
