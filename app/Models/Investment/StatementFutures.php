<?php

namespace App\Models\Investment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class StatementFutures extends Model
{
    protected $table = 'statement_futures';

    protected $fillable = [
        'period',
        'commitment',
        'open_interest',
        'profit',
        'real_commitment',
        'net_commitment',
        'distribution',
        'note',
    ];

    protected $dates = [
        'period',
    ];

    public function setPeriodAttribute($period)
    {
        if (!$period instanceof Carbon) {
            $period = Carbon::parse($period);
        }

        $this->attributes['period'] = $period->startOfMonth();
    }

    public function scopePeriod($query, $value)
    {
        if (!$value instanceof Carbon) {
            $value = Carbon::parse($value);
        }

        return $query->where('period', $value->startOfMonth()->toDateString());
    }
}
