<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Contracts\RepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function __construct(protected RepositoryInterface $productRepository) {}

    public function index(Request $request, $category_slug = 'all-categories'): View|string
    {
        $orderBy = $request->input('orderBy') ?? 'default';
        $products  = $this->productRepository->getProducts(8, $orderBy, $category_slug);
        if ($request->ajax()) {
            return $this->ajaxResponse($products);
        }

        $category = $this->getCurrentCategory($category_slug);

        return view('catalog.index', compact('products', 'category'));
    }

    public function showProduct(string $category, Product $product): View
    {
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
