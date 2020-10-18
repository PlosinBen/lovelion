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
        'note'
    ];

    protected $dates = ['date'];

    public function Ledger()
    {
        return $this->belongsTo(Ledger::class);
    }

    public function LedgerRecordDetail()
    {
        return $this->hasMany(LedgerRecordDetail::class);
    }

    public function LedgerRecordAttach()
    {
        return $this->hasMany(LedgerRecordAttach::class);
    }

}
