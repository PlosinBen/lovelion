<?php

namespace App\Models\Bookkeeping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LedgerRecord extends Model
{
    use HasFactory;

    protected $table = 'ledger_record';

    protected $fillable = [
        'ledger_id',
        'date',
        'locate',
        'total',
    ];

    protected $dates = ['date'];
}
