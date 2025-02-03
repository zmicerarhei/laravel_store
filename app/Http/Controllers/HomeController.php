<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $randomProducts = Product::inRandomOrder()->take(8)->get();

        /**
         * @var view-string $viewName
         */
        $viewName = 'home.index';

        return view($viewName, ['products' => $randomProducts]);
    }
}
