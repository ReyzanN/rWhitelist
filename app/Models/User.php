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

    /*
     * References
     */

    public function userRank(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->hasMany(UserRank::class,'userId', 'id')->get();
    }

    public function QCMApplication(){
        return $this->hasMany(QCMCandidate::class,'idUser','id')->get();
    }

    /* --- */

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

    public function updateRole(array $NewRole) :void {
        $UserRole = $this->userRank();
        // Check For New Role
        foreach ($NewRole as $NR){
            $Check = false;
            foreach ($UserRole as $UR){
                if ($NR == $UR->roleId){
                    $Check = true;
                    break;
                }
            }
            if (!$Check){
                UserRank::create([
                    'userId' => $this->id,
                    'roleId' => $NR
                ]);
            }
        }
        // Check for remove old Role
        foreach ($UserRole as $UR){
            $Check = false;
            foreach ($NewRole as $NR){
                if ($NR == $UR->roleId){
                    $Check = true;
                    break;
                }
            }
            if (!$Check){
                $TempRole = UserRank::find($UR->id);
                $TempRole->delete();
            }
        }
    }

    /*
     * Rank Checking
     */

    /**
     * @usage Check if user is WL
     * @return bool
     */
    public function isWl() : bool {
        foreach ($this->userRank() as $R) {
            if ($R->roleId == env('APP_DISCORD_WL')) {
                return true;
            }
        }
        return false;
    }

    /**
     * @usage Check if user is Recruiter
     * @return bool
     */
    public function isRe() : bool {
        foreach ($this->userRank() as $R) {
            if ($R->roleId == env('APP_DISCORD_RE')) {
                return true;
            }
        }
        return false;
    }

    public function isRanked(): bool {
        foreach ($this->userRank() as $R) {
            if ($R->roleId == env('APP_DISCORD_AD') || $R->roleId == env('APP_DISCORD_MOD') || $R->roleId == env('APP_DISCORD_SUP')) {
                return true;
            }
        }
        return false;
    }

    /*
     * QCM Apply
     */
    public function CanApplyForQCM(): bool
    {
        $CountChance = count($this->QCMApplication());
        if ($CountChance >= env('APP_WHITELIST_QCM_ATTEMPT')) { return false;};
        return true;
    }

    public function GetChanceForQCM(): int
    {
        return env('APP_WHITELIST_QCM_ATTEMPT') - count($this->QCMApplication());
    }

    public function GetAttemptForQCM() :int {
        $Count = count($this->QCMApplication());
        if ($Count == 0) { return 1;}
        if ($Count == 1) { return 2;}
        return 0;
    }


}
