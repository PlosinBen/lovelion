<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;
use App\Service\InvestmentService;
use Illuminate\Http\Request;

class CommitmentController extends Controller
{
    private InvestmentService $investmentService;

    public function __construct(InvestmentService $investmentService)
    {
        $this->investmentService = $investmentService;

        $this->pushBreadcrumbsNode('投資');
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $filter = [
            'investment_user_id' => $user->InvestmentUser->id,
            'orderBy' => 'period DESC',
        ];

        return $this
            ->pushBreadcrumbsNode('歷史權益')
            ->view('investment.commitment.index', [
                'CommitmentList' => $this->investmentService->getCommitmentList($filter)
            ]);
    }
}
