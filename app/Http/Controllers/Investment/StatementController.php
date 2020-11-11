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
                    'orderBy' => 'period DESC'
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
            $investmentServices->updateUsersTypeGroup($period);

            $this->statementService->pretreatment($period);
            echo $period->toDateString();
        } while ($period->addMonth() && $period->lessThan($now));
    }
}
