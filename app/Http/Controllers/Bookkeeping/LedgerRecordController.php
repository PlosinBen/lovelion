<?php

namespace App\Http\Controllers\Bookkeeping;

use App\Http\Controllers\Controller;
use App\Package\RequestValidator;
use App\Service\BookkeepingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LedgerRecordController extends Controller
{
    private BookkeepingService $BookkeepingService;

    public function __construct(BookkeepingService $bookkeepingService)
    {
        $this->BookkeepingService = $bookkeepingService;

        $this->pushBreadcrumbsNode('Ledger', route('bookkeeping.ledger.index'));
    }

    public function show($id)
    {
        $user = auth()->user();

        $ledgerRecord = $this->BookkeepingService->getLedgerRecord($id);
        if ($ledgerRecord->Ledger->user_id != $user->id) {
            return abort(403);
        }

        return $this
            ->pushBreadcrumbsNode($ledgerRecord->Ledger->name, route('bookkeeping.ledger.show', $ledgerRecord->Ledger->id))
            ->pushBreadcrumbsNode('編輯 #'.$ledgerRecord->id)
            ->view('bookkeeping.ledger.editRecord', [
                'ledgerRecord' => $ledgerRecord,
                'action' => route('bookkeeping.ledgerRecord.update', $ledgerRecord->Ledger->id),
                'method' => 'PUT',
            ]);
    }

    public function create(RequestValidator $requestValidator)
    {
        $user = auth()->user();

        $params = $requestValidator
            ->rule([
                'ledger_id' => 'required',
            ])
            ->validate()
            ->get();

        if (! $requestValidator->passes()) {
            return redirect()->route('dashboard');
        }

        $ledger = $this->BookkeepingService->getLedger($params['ledger_id']);

        if ($ledger->user_id != $user->id) {
            return abort(403);
        }

        $ledgerRecord = [
            'id' => 'new',
            'Ledger' => $ledger,
            'ledger_record_detail' => [],
            'ledger_record_attach' => [],
        ];

        return $this
            ->pushBreadcrumbsNode('新增')->view('bookkeeping.ledger.editRecord', [
                'ledgerRecord' => json_decode(json_encode($ledgerRecord)),
                'action' => route('bookkeeping.ledgerRecord.store', ['ledger_id' => $ledger->id]),
            ]);
    }

    public function update($id, Request $request)
    {
        $this->BookkeepingService->updateLedger($id, $request->get('ledgerRecord'));

        $this->BookkeepingService->updateLedgerRecord(
            $id,
            $request->get('ledgerRecordDetail'),
            $request->get('ledgerRecordAttach')
        );

        return redirect()->route('bookkeeping.ledger.show', $id);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $params = $request->all();

        $ledger = $this->BookkeepingService->getLedger($params['ledger_id']);

        if ($ledger->user_id != $user->id) {
            return abort(403);
        }

        $ledgerRecord = $this->BookkeepingService->createLedgerRecord($user->id, $ledger->id, $params['ledgerRecord']);

        $this->BookkeepingService->updateLedgerRecord(
            $ledgerRecord->id,
            $request->get('ledgerRecordDetail'),
            $request->get('ledgerRecordAttach')
        );

        return redirect()->route('bookkeeping.ledger.show', $ledger->id);
    }
}
