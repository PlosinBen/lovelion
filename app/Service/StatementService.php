<?php

namespace App\Service;

use App\Http\Requests\AddStatementRequests;
use App\Repository\Statement\StatementFuturesRepository;
use Illuminate\Support\Carbon;

class StatementService
{
    private StatementFuturesRepository $statementFuturesRepository;

    public function __construct(StatementFuturesRepository $statementFuturesRepository)
    {
        $this->statementFuturesRepository = $statementFuturesRepository;
    }

    public function getFuturesList($filter)
    {
        return $this->statementFuturesRepository
            ->perPage(24)
            ->fetchPagination($filter);
    }

    public function add(array $columns)
    {
        return $this->statementFuturesRepository->insert($columns);
    }

    public function pretreatment(Carbon $period, $deposit, $withdraw, $transfer)
    {
        $prePeriodStatement = $this->statementFuturesRepository
            ->fetchByPeriod($period->copy()->firstOfMonth()->subMonth());

        $statement = $this->statementFuturesRepository->fetchByPeriod($period);

        #實際權益
        $statement->real_commitment = $statement->commitment - $statement->open_interest;

        #權益變動損益
        $statement->net_commitment = $statement->real_commitment
            - $prePeriodStatement->real_commitment
            - $deposit
            + $withdraw
            - $transfer;

        #可分配總額
        $statement->distribution = $statement->net_commitment;
        if ($statement->profit != 0) {
            $statement->distribution = min($statement->net_commitment, $statement->profit);
        }

        $statement->save();

        return $statement;
    }
}
