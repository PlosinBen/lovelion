<?php

namespace App\Http\Controllers\Bookkeeping;

use App\Http\Controllers\Controller;
use App\Package\RequestValidator;
use App\Service\BookkeepingService;
use Illuminate\Validation\Rule;

class LedgerController extends Controller
{
    private BookkeepingService $BookkeepingService;

    public function __construct(BookkeepingService $bookkeepingService)
    {
        $this->BookkeepingService = $bookkeepingService;

        $this->pushBreadcrumbsNode('Ledger', route('bookkeeping.ledger.index'));
    }

    public function index()
    {
        return $this->view('bookkeeping.ledger.index', [
            'ledgerEntities' => $this->BookkeepingService->getLedgerList([]),
        ]);
    }

    public function show($id)
    {
        $ledger = $this->BookkeepingService->getLedger($id);

        if ($ledger === null) {
            return redirect()->route('ledger.index');
        }

        return $this
            ->pushBreadcrumbsNode("{$ledger->name}")
            ->view('bookkeeping.ledger.show', [
                'ledger' => $ledger,
                'ledgerRecords' => $this->BookkeepingService->getLedgerRecordList($id),
                'statistics' => $this->BookkeepingService->getLedgerStatistics($id),
            ]);
    }

    public function store(RequestValidator $requestValidator)
    {
        $columns = $requestValidator
            ->rule([
                'name' => 'required',
                'currency_code' => [
                    'required',
                    Rule::in(collect(config('currency'))->keys()),
                ],
            ])
            ->validate()
            ->get();

        if (! $requestValidator->passes()) {
            return redirect()
                ->route('dashboard')
                ->withErrors($requestValidator->errors());
        }

        $user = auth()->user();

        $this->BookkeepingService->createLedger($user->id, $columns);

        return redirect()->route('dashboard');
    }
}
