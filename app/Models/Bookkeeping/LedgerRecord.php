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
        'note',
    ];

    protected $dates = ['date'];

    public function scopeLedgerId($query, $val)
    {
        switch (gettype($val)) {
            case 'string':
                $val = explode(',', $val);
                // no break
            case 'array':
                return $query->whereIn('ledger_id', $val);
                break;
            case 'int':
                return $query->where('ledger_id', $val);
            default:
                return $query;
        }
    }

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
