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
}
