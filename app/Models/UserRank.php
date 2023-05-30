<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRank extends Model
{
    protected $table = "user_role";
    protected $fillable = [
        'userId',
        'roleId'
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'userId')->get()->first();
    }
}
