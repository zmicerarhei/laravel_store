<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ClientProductService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(ClientProductService $ClientProductService): View
    {
        $products = $ClientProductService->getRandomProducts(8);

        /**
         * @var view-string $viewName
         */
        $viewName = 'home.index';

        return view($viewName, compact('products'));
    }
}
