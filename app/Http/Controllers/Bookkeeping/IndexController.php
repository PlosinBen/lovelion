<?php

namespace App\Http\Controllers\Bookkeeping;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
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

    public function store(Request $request)
    {
        $columns = $request->all();


    }
}
