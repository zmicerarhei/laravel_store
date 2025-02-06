<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\CategoryServiceInterface;
use App\Contracts\CurrencyServiceInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Services\ProductService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ProductService $produtService,
        private CurrencyServiceInterface $currencyService,
        private CategoryServiceInterface $categoryservice
    ) {
        //
    }

    public function index(Request $request, string $category_slug = 'all-categories'): View|string
    {
        $products  = $this->produtService->getPaginatedProducts(8, $request->input('orderBy'), $category_slug);
        if ($request->ajax()) {
            return $this->ajaxResponse($products);
        }

        $category = $this->categoryservice->getCategoryBySlug($category_slug);

        return view('catalog.index', compact('products', 'category'));
    }

    public function showProduct(string $category, Product $product): View
    {

        foreach ($product->services as $service) {
            /** @var Service $service */
            $service->price = $this->currencyService->convert((float)$service->price);
        }

        $product->price = $this->currencyService->convert((float)$product->price);


        return view('catalog.show', compact('product', 'category'));
    }

    /**
     * @param LengthAwarePaginator<Product> $products
     * @return string
     */
    private function ajaxResponse(LengthAwarePaginator $products): string
    {
        return view('partials.products', compact('products'))->render();
    }
}
