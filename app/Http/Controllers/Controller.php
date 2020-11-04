<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected array $breadcrumbs = [];

    protected function pushBreadcrumbsNode($name, $url = null): self
    {
        $this->breadcrumbs[$name] = $url;

        return $this;
    }

    protected function view($view, $params = [])
    {
        $params += [
            '_breadcrumbs' => $this->breadcrumbs,
        ];

        return view($view, $params);
    }
}
