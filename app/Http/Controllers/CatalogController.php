<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Contracts\RepositoryInterface;
use App\Services\CurrencyService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CatalogController extends Controller
{
    public function __construct(protected RepositoryInterface $productRepository, protected CurrencyService $currencyService) {}

    public function index(Request $request, $category_slug = 'all-categories'): View|string
    {
        $orderBy = $request->input('orderBy') ?? 'default';
        $products  = $this->productRepository->getProducts(8, $orderBy, $category_slug);
        foreach ($products as $product) {
            $product->price = $this->currencyService->convert($product->price);
        };
        if ($request->ajax()) {
            return $this->ajaxResponse($products);
        }

        $category = $this->getCurrentCategory($category_slug);

        return view('catalog.index', compact('products', 'category'));
    }

    public function showProduct(string $category, Product $product): View
    {

        foreach ($product->services as $service) {
            $service->price = $this->currencyService->convert($service->price);
        }

        $product->price = $this->currencyService->convert($product->price);


        return view('catalog.show', compact('product', 'category'));
    }

    protected function getCurrentCategory($category_slug)
    {
        if ($category_slug !== 'all-categories') {
            return Category::where('slug', $category_slug)->firstOrFail();
        }
        return null;
    }

    protected function ajaxResponse($products): string
    {
        return view('partials.products', compact('products'))->render();
    }
}
