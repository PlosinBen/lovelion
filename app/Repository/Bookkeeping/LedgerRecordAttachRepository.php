<?php

namespace App\Repository\Bookkeeping;

use App\Models\Bookkeeping\LedgerRecordAttach;
use App\Repository\Repository;

class LedgerRecordAttachRepository extends Repository
{
    public function __construct(LedgerRecordAttach $ledgerRecordAttach)
    {
        $this->Model = $ledgerRecordAttach;
    }

    public function replaceRecord($ledgerRecordId, $attaches)
    {
        $model = clone $this->Model;

        $model
            ->where('ledger_record_id', $ledgerRecordId)
            ->update([
                'updated_at' => null,
            ]);

        foreach ($attaches ?? [] as $attach) {
            if ($attach['id'] === null) {
                $attach['ledger_record_id'] = $ledgerRecordId;
                LedgerRecordAttach::insert($attach);
                continue;
            }

            $id = $attach['id'];
            unset($attach['id']);
            $model
                ->where('ledger_record_id', $ledgerRecordId)
                ->where('id', $id)
                ->update($attach);
        }

        $model = clone $this->Model;
        $model->where('updated_at', null)
            ->delete();
    }
}
