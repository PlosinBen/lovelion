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

        $this->pushBreadcrumbsNode('投資', route('investment.commitment.index'));
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
                'CommitmentList' => $this->investmentService->getCommitmentList($filter),
            ]);
    }

    public function show($period, Request $request)
    {
        $user = $request->user();

        $filter = [
            'investment_user_id' => $user->InvestmentUser->id,
            'period' => $period,
            'orderBy' => 'period DESC',
        ];

        $commitments = $this->investmentService->getCommitment($filter);

        if ($commitments->count() === 0) {
            return redirect()->route('investment.commitment.index');
        }

        return $this
            ->pushBreadcrumbsNode($period)
            ->view('investment.commitment.show', [
                'Commitments' => $commitments,
                'Details' => $this->investmentService->getDetailByCommitment($commitments->first()),
            ]);
    }
}
