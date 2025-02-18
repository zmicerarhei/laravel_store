<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(ProductRepository $productRepository): View
    {
        $products = $productRepository->getRandomProducts(8);

        /**
         * @var view-string $viewName
         */
        $viewName = 'home.index';

        return view($viewName, compact('products'));
    }
}
