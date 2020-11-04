<?php

namespace App\Models\Bookkeeping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LedgerRecordDetail extends Model
{
    use HasFactory;

    protected $table = 'ledger_record_detail';

    protected $fillable = [
        'ledger_record_id',
        'name',
        'unit',
        'quantity',
        'other',
        'subtotal',
    ];
}
