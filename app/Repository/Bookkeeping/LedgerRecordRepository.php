<?php

namespace App\Repository\Bookkeeping;

use App\Models\Bookkeeping\LedgerRecord;
use App\Repository\Repository;

class LedgerRecordRepository extends Repository
{
    public function __construct(LedgerRecord $ledgerRecord)
    {
        $this->Model = $ledgerRecord;
    }

    public function calcStatistics($ledgerId)
    {
        return $this->Model
            ->where('ledger_id', $ledgerId)
            ->selectRaw('COUNT(*) AS count, SUM(total) AS total')
            ->first();
    }
}
