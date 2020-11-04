<?php

namespace App\Models\Bookkeeping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;

    protected $table = 'ledger';

    protected $fillable = [
        'user_id',
        'name',
        'currency_code',
    ];

    public function LedgerRecord()
    {
        return $this->hasMany(LedgerRecord::class);
    }
}
