<?php

namespace App\Repository\Investment;

use App\Models\Investment\InvestmentDetail;
use App\Repository\Repository;
use Illuminate\Support\Carbon;

class InvestmentDetailRepository extends Repository
{
    public function __construct(InvestmentDetail $investmentDetail)
    {
        $this->Model = $investmentDetail;
    }

    public function fetchCommitmentDetail($commitment)
    {
        return $this->fetch([
            'investment_user_id' => $commitment->investment_user_id,
            'period' => $commitment->period,
            'orderBy' => 'date DESC',
        ]);
    }

    public function fetchByPeriod(Carbon $period)
    {
        return $this->fetch([
            'period' => $period
        ]);
    }
}
