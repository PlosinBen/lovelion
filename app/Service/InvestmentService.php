<?php

namespace App\Service;

use App\Repository\Investment\InvestmentAccountingRepository;
use App\Repository\Investment\InvestmentDetailRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class InvestmentService
{
    private InvestmentAccountingRepository $investmentAccountingRepository;
    private InvestmentDetailRepository $investmentDetailRepository;

    public function __construct(
        InvestmentAccountingRepository $investmentAccountingRepository,
        InvestmentDetailRepository $investmentDetailRepository
    )
    {
        $this->investmentAccountingRepository = $investmentAccountingRepository;
        $this->investmentDetailRepository = $investmentDetailRepository;
    }

    public function getCommitmentList(array $filter): LengthAwarePaginator
    {
        return $this->investmentAccountingRepository
            ->perPage(20)
            ->fetchPagination($filter);
    }

    public function getCommitment(array $filter)
    {
        return $this->investmentAccountingRepository
            ->fetch($filter);
    }

    public function getDetailByCommitment($commitment)
    {
        return $this->investmentDetailRepository
            ->fetchCommitmentDetail($commitment);
    }

    public function getAccountEstimate(Carbon $period): Collection
    {
        $prePeriodAccounting = $this->investmentAccountingRepository
            ->fetchByPeriod($period->copy()->subMonth())
            ->keyBy('investment_user_id');

        $weightUnit = config('investment.weightUnit');

        return $this->investmentDetailRepository
            ->fetchByPeriod($period)
            ->groupBy('investment_user_id')
            ->map(function ($investmentUserGroup, $investmentUserId) use ($prePeriodAccounting, $weightUnit) {
                $userPerPeriodAccounting = $prePeriodAccounting->get($investmentUserId);

                $userAccountingEstimate = $investmentUserGroup
                    ->groupBy('type')
                    ->map(function ($typeGroup) {
                        return $typeGroup->sum('amount');
                    })
                    ->put('pre_commitment', $userPerPeriodAccounting->commitment);

                $profitAbleCommitment = $userPerPeriodAccounting->commitment
                    - $userAccountingEstimate->get('withdraw', 0)
                    + $userAccountingEstimate->get('transfer', 0);

                $weight = 0;

                if ($profitAbleCommitment > 0) {
                    $weight = max(floor($profitAbleCommitment / $weightUnit), 0.5);
                }

                return $userAccountingEstimate->put('weight', $weight);
            });
    }

    public function updateUsersTypeGroup(Carbon $period)
    {
        $prePeriodAccounting = $this->investmentAccountingRepository
            ->fetchByPeriod($period->copy()->subMonth())
            ->keyBy('investment_user_id');

        $investmentAccounting = collect();

        $this->investmentDetailRepository
            ->fetchByPeriod($period)
            ->groupBy('investment_user_id')
            ->each(function ($investmentUserGroup, $investmentUserId) use ($prePeriodAccounting, $period, $investmentAccounting) {
                $userTypeData = $investmentUserGroup
                    ->groupBy('type')
                    ->map(function ($typeGroup) {
                        return $typeGroup->sum('amount');
                    });

                $userPrePeriodAccounting = $prePeriodAccounting->get($investmentUserId);

                $commitment = $userPrePeriodAccounting->commitment
                    + $userTypeData->get('deposit', 0)
                    - $userTypeData->get('withdraw', 0)
                    + $userTypeData->get('profit', 0)
                    + $userTypeData->get('expense', 0)
                    + $userTypeData->get('transfer', 0);

                $userTypeData->put('commitment', $commitment);

                $investmentAccounting->put($investmentUserId,
                    $this->investmentAccountingRepository->setUserPeriodValue($investmentUserId, $period, $userTypeData),
                );
            });

        return $investmentAccounting;
    }
}
