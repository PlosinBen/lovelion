<?php

namespace App\Models\Investment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class InvestmentAccounting extends Model
{
    public $table = 'investment_accounting';

    protected $fillable = [
        'period',
        'investment_user_id',
        'deposit',
        'withdraw',
        'profit',
        'transfer',
        'expense',
        'commitment',
    ];

    public function setPeriodAttribute($period)
    {
        if (! $period instanceof Carbon) {
            $period = Carbon::parse($period);
        }

        $this->attributes['period'] = $period->startOfMonth();
    }

    public function scopeInvestmentUserId($query, $value)
    {
        if (is_int($value)) {
            $query->where('investment_user_id', $value);
        }

        return $query;
    }

    public function scopePeriod($query, $value)
    {
        if (is_string($value) && strlen($value) === 0) {
            return $query;
        }

        if (! $value instanceof Carbon) {
            $value = Carbon::parse($value);
        }

        return $query->where('period', $value->startOfMonth());
    }
}
