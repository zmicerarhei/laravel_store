<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Contracts\ProductRepositoryInterface;
use App\Contracts\AdminProductServiceInterface;
use App\Contracts\ClientProductServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveProductRequest;
use App\Models\Service;
use App\Models\Product;
use App\Models\Category;
use App\Contracts\RepositoryInterface;
use App\Jobs\ExportAndSendReport;
use App\Models\Brand;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function __construct(private AdminProductServiceInterface $adminProductService) {}

    public function index(): View
    {
        $products = $this->adminProductService->getAllProducts();
        return view('admin.products.index', ['products' => $products]);
    }

    public function create(): View
    {
        $data = $this->adminProductService->getDataForCreateView();
        return view('admin.products.create_update', $data);
    }

    public function store(SaveProductRequest $request): RedirectResponse
    {
        $product = $this->adminProductService->addNewProduct($request->only(
            'name',
            'brand_id',
            'category_id',
            'description',
            'release_date',
            'price'
        ));

        $this->adminProductService->syncServicesToProduct($product, $request->input('services') ?? []);

        return redirect()->route('admin.products.index')->with('success', 'Продукт успешно создан.');
    }

    public function edit(Product $product): View
    {
        $brands = Brand::all();
        $categories = Category::all();
        $services = Service::all();
        $product->load('services');
        $selectedServices = $product->services->pluck('id')->toArray();
        $fields = config('productForm.fields');
        return view(
            'admin.products.create_update',
            compact('services', 'brands', 'categories', 'selectedServices', 'fields', 'product')
        );
    }

    public function update(
        ProductRepositoryInterface $productRepository,
        SaveProductRequest $request,
        Product $product
    ): RedirectResponse {
        $productRepository->updateProduct($product, $request->only(
            'name',
            'brand_id',
            'category_id',
            'description',
            'release_date',
            'price'
        ));
        $product->services()->sync($request->input('services'));
        return redirect()->route('admin.products.index')->with('success', 'Продукт успешно обновлен.');
    }

    public function delete(ProductRepositoryInterface $productRepository, Product $product): RedirectResponse
    {
        $productRepository->deleteProduct($product);
        return redirect()->route('admin.products.index')->with('success', 'Продукт успешно удален.');
    }

    public function exportProductsToCsv(): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        ExportAndSendReport::dispatch($user);
        return redirect()->back()->with('success', 'Отчет отправлен в обработку.');
    }
}
