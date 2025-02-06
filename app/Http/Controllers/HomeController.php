<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(ProductService $productService): View
    {
        $products = $productService->getRandomProducts(8);

        /**
         * @var view-string $viewName
         */
        $viewName = 'home.index';

        return view($viewName, compact('products'));
    }
}
