<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestRoutingLog extends Model
{
    use HasFactory;

    protected $table = "guest_logs_routing";

    protected $fillable = [
        'guestInformations',
        'url',
    ];

    /*
     * Functions
     */
    public static function Clear(){
        foreach (GuestRoutingLog::all() as $Element){
            $Element->delete();
        }
    }
}
