<?php

namespace App\Models\Member;

use App\Models\Investment\InvestmentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';

    protected $fillable = [
        'name',
        'avator',
    ];

    public function UserOpenId()
    {
        return $this->hasMany(UserOPenId::class);
    }

    public function InvestmentUser()
    {
        return $this->hasOne(InvestmentUser::class);
    }
}
