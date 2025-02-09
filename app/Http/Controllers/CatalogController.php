<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\CategoryServiceInterface;
use App\Contracts\ClientProductServiceInterface;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function __construct(
        private ClientProductServiceInterface $ClientProductService,
        private CategoryServiceInterface $categoryservice
    ) {
        //
    }

    public function index(Request $request, string $category_slug = 'all-categories'): View|string
    {
        $products  = $this->ClientProductService->getPaginatedProducts(
            Product::ITEMS_PER_PAGE,
            $request->input('orderBy'),
            $category_slug,
            Product::DEFAULT_RELATIONS,
        );

        if ($request->ajax()) {
            return $this->ClientProductService->generateAjaxResponse($products);
        }

        $category = $this->categoryservice->getCategoryBySlug($category_slug);

        return view('catalog.index', compact('products', 'category'));
    }

    public function showProduct(string $category, Product $product): View
    {
        $this->ClientProductService->updatePrices($product);
        return view('catalog.show', compact('product', 'category'));
    }
}
