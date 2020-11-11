<?php

namespace App\Service;

use App\Repository\Investment\InvestmentAccountingRepository;
use App\Repository\Investment\InvestmentDetailRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

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

    public function updateUsersTypeGroup(Carbon $period)
    {
        $prePeriodAccounting = $this->investmentAccountingRepository
            ->fetchByPeriod($period->copy()->subMonth())
            ->keyBy('investment_user_id');

        $data = $this->investmentDetailRepository
            ->fetchByPeriod($period)
            ->groupBy('investment_user_id')
            ->each(function ($investmentUserGroup, $investmentUserId) use ($prePeriodAccounting, $period) {
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

                $this->investmentAccountingRepository
                    ->setUserPeriodValue($investmentUserId, $period, $userTypeData);
            });


        dd($data);
    }
}
