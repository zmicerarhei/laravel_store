<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\ClientProductServiceInterface;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function __construct(
        private ClientProductServiceInterface $clientProductService,
        private CategoryRepositoryInterface $categoryRepository
    ) {
        //
    }

    public function index(Request $request, ?string $category_slug = null): View|string
    {
        $products  = $this->clientProductService->getPaginatedProducts(
            Product::ITEMS_PER_PAGE,
            $request->input('orderBy'),
            $category_slug,
            Product::DEFAULT_RELATIONS,
        );

        if ($request->ajax()) {
            return $this->clientProductService->generateAjaxResponse($products);
        }

        $category = $this->categoryRepository->getCategoryBySlug($category_slug);

        return view('catalog.index', compact('products', 'category'));
    }

    public function showProduct(string $category, Product $product): View
    {
        $this->clientProductService->updatePrices($product);
        return view('catalog.show', compact('product', 'category'));
    }
}
