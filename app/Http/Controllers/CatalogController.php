<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\CurrencyServiceInterface;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Contracts\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function __construct(protected RepositoryInterface $productRepository, protected CurrencyServiceInterface $currencyService) {}

    public function index(Request $request, string $category_slug = 'all-categories'): View|string
    {
        $orderBy = $request->input('orderBy') ?? 'default';
        $products  = $this->productRepository->getProducts(8, $orderBy, $category_slug);
        foreach ($products->items() as $product) {
            $product->price = $this->currencyService->convert((float)$product->price);
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
            /** @var Service $service */
            $service->price = $this->currencyService->convert((float)$service->price);
        }

        $product->price = $this->currencyService->convert((float)$product->price);


        return view('catalog.show', compact('product', 'category'));
    }

    protected function getCurrentCategory(string $category_slug): ?Category
    {
        if ($category_slug !== 'all-categories') {
            return Category::where('slug', $category_slug)->firstOrFail();
        }
        return null;
    }

    /**
     * @param LengthAwarePaginator<Product> $products
     * @return string
     */
    protected function ajaxResponse(LengthAwarePaginator $products): string
    {
        return view('partials.products', compact('products'))->render();
    }
}
