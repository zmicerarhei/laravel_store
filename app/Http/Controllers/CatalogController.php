<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\ClientProductServiceInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function __construct(
        private ClientProductServiceInterface $clientProductService,
        private CategoryRepositoryInterface $categoryRepository,
        private ProductRepositoryInterface $productRepository
    ) {
        //
    }

    public function index(Request $request, ?string $categorySlug = null): View|string
    {
        $products = $this->clientProductService->getPaginatedProducts(
            $categorySlug,
            $request->input('orderBy'),
            Product::DEFAULT_RELATIONS,
            Product::ITEMS_PER_PAGE
        );

        if ($request->ajax()) {
            return $this->clientProductService->generateAjaxResponse($products);
        }

        $category = $this->categoryRepository->getCategoryBySlug($categorySlug);

        return view('catalog.index', compact('products', 'category'));
    }

    public function showProduct(string $category, Product $product): View
    {
        return view('catalog.show', compact('product', 'category'));
    }
}
