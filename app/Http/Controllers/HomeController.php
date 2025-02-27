<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __construct(public ProductRepositoryInterface $productRepository)
    {
    }

    public function index(): View
    {
        $products = $this->productRepository->getRandomProducts(8);

        /**
         * @var view-string $viewName
         */
        $viewName = 'home.index';

        return view($viewName, compact('products'));
    }
}
