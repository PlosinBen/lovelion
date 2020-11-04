<?php

namespace App\Service;

use App\Repository\Bookkeeping\LedgerRecordAttachRepository;
use App\Repository\Bookkeeping\LedgerRecordDetailRepository;
use App\Repository\Bookkeeping\LedgerRecordRepository;
use App\Repository\Bookkeeping\LedgerRepository;
use Illuminate\Support\Collection;

class BookkeepingService
{
    private LedgerRepository $LedgerRepository;
    private LedgerRecordRepository $LedgerRecordRepository;
    private LedgerRecordDetailRepository $LedgerRecordDetailRepository;
    private LedgerRecordAttachRepository $LedgerRecordAttachRepository;

    public function __construct(
        LedgerRepository $ledgerRepository,
        LedgerRecordRepository $ledgerRecordRepository,
        LedgerRecordDetailRepository $ledgerRecordDetailRepository,
        LedgerRecordAttachRepository $ledgerRecordAttachRepository
    ) {
        $this->LedgerRepository = $ledgerRepository;
        $this->LedgerRecordRepository = $ledgerRecordRepository;
        $this->LedgerRecordDetailRepository = $ledgerRecordDetailRepository;
        $this->LedgerRecordAttachRepository = $ledgerRecordAttachRepository;
    }

    public function createLedger($userId, Collection $columns)
    {
        $this->LedgerRepository
            ->create(
                $userId,
                $columns->get('name'),
                $columns->get('currency_code')
            );
    }

    public function getLedger($id)
    {
        return $this->LedgerRepository
            ->find($id);
    }

    public function getLedgerAll($filter = [])
    {
        return $this->LedgerRepository
            ->with('LedgerRecord')
            ->fetch($filter)
            ->map(function ($row) {
                $row->expenses = $row->LedgerRecord
                    ->where('total', '<', 0)
                    ->sum('total');

                return $row;
            });
    }

    public function getLedgerList($filter = [])
    {
        $ledgerPagination = $this->LedgerRepository
            ->with('LedgerRecord')
            ->fetchPagination($filter);

        return $ledgerPagination;
    }

    public function getLedgerStatistics($id)
    {
        return $this->LedgerRecordRepository->calcStatistics($id);
    }

    public function getLedgerRecord($id)
    {
        return $this->LedgerRecordRepository
            ->with('Ledger')
            ->with('LedgerRecordDetail')
            ->with('LedgerRecordAttach')
            ->find($id);
    }

    public function getLedgerRecordList($id, $filter = [])
    {
        $filter['ledger_id'] = $id;
        $filter['orderBy'] = [
            'date DESC',
            'id ASC',
        ];

        return $this->LedgerRecordRepository
            ->perPage(30)
            ->fetchPagination($filter);
    }

    public function updateLedger($id, $ledger)
    {
        $ledger['note'] = $ledger['note'] ?? '';

        $this->LedgerRecordRepository->update($id, collect($ledger));
    }

    public function updateLedgerRecord($id, $details, $attaches)
    {
        $this->LedgerRecordDetailRepository->replaceRecord($id, $details);
        $this->LedgerRecordAttachRepository->replaceRecord($id, $attaches);
    }

    public function createLedgerRecord($userId, $ledgerId, $columns)
    {
        return $this->LedgerRecordRepository->create(
            $userId,
            $ledgerId,
            $columns['locate'],
            $columns['note']
        );
    }
}
