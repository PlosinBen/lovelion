<?php

namespace App\Service;

use App\Repository\Investment\InvestmentAccountingRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class InvestmentService
{
    private InvestmentAccountingRepository $investmentAccountingRepository;

    public function __construct(
        InvestmentAccountingRepository $investmentAccountingRepository
    ) {
        $this->investmentAccountingRepository = $investmentAccountingRepository;
    }

    public function getCommitmentList(array $filter): LengthAwarePaginator
    {
        return $this->investmentAccountingRepository
            ->perPage(20)
            ->fetchPagination($filter);
    }
}
