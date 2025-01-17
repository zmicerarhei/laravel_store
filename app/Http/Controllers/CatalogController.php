<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\Interfaces\RepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function __construct(protected RepositoryInterface $productRepository) {}

    public function index(Request $request): View|string
    {
        $orderBy = $request->input('orderBy') ?? 'default';
        ['products' => $products, 'filters' => $filters]
            = $this->productRepository->getProducts(8, $orderBy, 'all-categories');
        if ($request->ajax()) {
            return view('partials.products', compact('products', 'filters'))->render();
        }
        return view('catalog.index', compact('products', 'filters'));
    }

    public function showProduct(string $category, Product $product): View
    {
        return view('catalog.show', compact('product', 'category'));
    }

    public function showProductsByCategory(Request $request, $category_slug): View|string
    {
        $orderBy = $request->input('orderBy') ?? 'default';
        $category = Category::where('slug', $category_slug)->firstOrFail();
        ['products' => $products, 'filters' => $filters]
            = $this->productRepository->getProducts(8, $orderBy, $category_slug);
        if ($request->ajax()) {
            return view('partials.products', compact('products', 'filters'))->render();
        }
        return view('catalog.index', compact('products', 'filters', 'category'));
    }
}
