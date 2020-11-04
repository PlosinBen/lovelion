<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOpenId extends Model
{
    use HasFactory;

    protected $table = 'user_open_id';

    protected $fillable = [
        'user_id',
        'provider',
        'open_id',
        'name',
        'avatar',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
