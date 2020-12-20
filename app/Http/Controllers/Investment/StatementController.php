<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddStatementRequests;
use App\Service\InvestmentService;
use App\Service\StatementService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StatementController extends Controller
{
    private StatementService $statementService;

    public function __construct(StatementService $statementService)
    {
        $this->statementService = $statementService;

        $this->pushBreadcrumbsNode('對帳單');
    }

    public function index()
    {
        return $this
            ->view('component.statement.index', [
                'FuturesStatements' => $this->statementService->getFuturesList([
                    'orderBy' => 'period DESC',
                ]),
            ]);
    }

    public function store(AddStatementRequests $addStatementRequests)
    {
        $this->statementService->add($addStatementRequests->validated());

        return redirect()->route('investment.statement.index');
    }

    public function show($period, InvestmentService $investmentServices)
    {
        $now = Carbon::now();
        $period = Carbon::parse($period);
        do {
            $accountEstimate = $investmentServices->getAccountEstimate($period);

            $statement = $this->statementService->pretreatment(
                $period,
                $accountEstimate->sum('deposit'),
                $accountEstimate->sum('withdraw'),
                $accountEstimate->sum('transfer')
            );

            #總權重
            $totalWeight = $accountEstimate->sum('weight');
            #每單位損益 = 可分配總額 / 前期總權重
            $perWeightProfit = floor($statement->distribution / $totalWeight);

            #分配損益
            $userProfit = $accountEstimate
                ->where('investment_user_id', '!=', 1)
                ->map(function ($futures) use ($perWeightProfit) {
                    return floor($futures->get('weight', 0) * $perWeightProfit);
                });

            $userProfit->put(1, $statement->net_commitment - $userProfit->sum());

            dd($userProfit);

            $investmentServices->distributionProfit();
        } while ($period->addMonth() && $period->lessThan($now));
    }
}
