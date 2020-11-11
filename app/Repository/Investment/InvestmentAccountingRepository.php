<?php

namespace App\Repository\Investment;

use App\Models\Investment\InvestmentAccounting;
use App\Repository\Repository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class InvestmentAccountingRepository extends Repository
{
    public function __construct(InvestmentAccounting $investmentAccounting)
    {
        $this->Model = $investmentAccounting;
    }

    public function fetchCommitment($investmentUserId, $period)
    {
        return $this->fetch([
            'investment_user_id' => $investmentUserId,
            'period' => $period,
        ]);
    }

    public function setUserPeriodValue($investmentUserId, Carbon $period, Collection $columns)
    {
        $statementAccountEntity = $this->Model->firstOrNew([
            'investment_user_id' => $investmentUserId,
            'period' => $period->firstOfMonth()->toDateString(),
        ]);

        $this->setEntityColumns($statementAccountEntity, $columns)
            ->save();

        return $statementAccountEntity;
    }

    public function fetchByPeriod(Carbon $period): Collection
    {
        return $this->fetch([
            'period' => $period,
        ]);
    }
}
