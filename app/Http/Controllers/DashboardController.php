<?php

namespace App\Http\Controllers;

use App\Service\BookkeepingService;

class DashboardController extends Controller
{
    public function index(BookkeepingService $bookkeepingService)
    {
        $user = auth()->user();

        $this->pushBreadcrumbsNode('Dashboard');

        return $this->view(
            'dashboard',
            [
                'ledgerEntities' => $bookkeepingService->getLedgerAll([
                    'userId' => $user->id,
                ]),
            ]
        );
    }
}
