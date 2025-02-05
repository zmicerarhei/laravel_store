<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\RepositoryInterface;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(RepositoryInterface $productRepository): View
    {
        $products = $productRepository->getRandomProducts(12);

        /**
         * @var view-string $viewName
         */
        $viewName = 'home.index';

        return view($viewName, compact('products'));
    }
}
