<?php

namespace App\Repository\Bookkeeping;

use App\Models\Bookkeeping\LedgerRecordDetail;
use App\Repository\Repository;

class LedgerRecordDetailRepository extends Repository
{
    public function __construct(LedgerRecordDetail $ledgerRecordDetail)
    {
        $this->Model = $ledgerRecordDetail;
    }

    public function replaceRecord($ledgerRecordId, $details)
    {
        $model = clone $this->Model;

        $model
            ->where('ledger_record_id', $ledgerRecordId)
            ->update([
                'updated_at' => null,
            ]);

        foreach ($details as $detail) {
            if ($detail['id'] === null) {
                $detail['ledger_record_id'] = $ledgerRecordId;
                $detail['other'] = $detail['other'] ?? 0;
                LedgerRecordDetail::insert($detail);
                continue;
            }

            $id = $detail['id'];
            unset($detail['id']);
            $model
                ->where('ledger_record_id', $ledgerRecordId)
                ->where('id', $id)
                ->update($detail);
        }

        $model = clone $this->Model;
        $model
            ->where('ledger_record_id', $ledgerRecordId)
            ->where('updated_at', null)
            ->delete();
    }
}
