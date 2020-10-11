<?php

namespace App\Http\Controllers\Bookkeeping;

use App\Http\Controllers\Controller;
use App\Package\RequestValidator;
use App\Service\BookkeepingService;
use Illuminate\Validation\Rule;

class LedgerController extends Controller
{
    public function __construct()
    {
        $this->pushBreadcrumbsNode('Ledger');
    }

    public function create()
    {
        $this->pushBreadcrumbsNode('Create');


        return $this->view('bookkeeping.create');
    }

    public function store(RequestValidator $requestValidator, BookkeepingService $bookkeepingService)
    {
        $columns = $requestValidator
            ->rule([
                'name' => 'required',
                'currency_code' => [
                    'required',
                    Rule::in(collect(config('currency'))->keys())
                ],
            ])
            ->validate()
            ->get();

        if( !$requestValidator->passes() ) {
            return redirect()
                ->route('dashboard')
                ->withErrors($requestValidator->errors());
        }

        $user = auth()->user();

        $bookkeepingService->createLedger($user->id, $columns);

        return redirect()->route('dashboard');
    }
}
