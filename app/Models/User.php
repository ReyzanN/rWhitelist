<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'discordAccountId',
        'discordUserName',
        'discordEmail',
        'lastConnection'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'discordAccountId',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function checkAccount(string $DiscordIDAccount) : bool {
        $User = User::where('discordAccountId', '=',$DiscordIDAccount)->get()->first();
        if ($User) { return true; }
        return false;
    }

    public static function findByDiscord(string $DiscordIDAccount) : User|Bool {
        $User = User::where('discordAccountId', '=',$DiscordIDAccount)->get()->first();
        if ($User) { return $User; }
        return false;
    }

    public function updateLastConnection(){
        $this->update(['lastConnection' => new \DateTime()]);
    }
}
