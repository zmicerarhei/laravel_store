<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Contracts\AdminProductServiceInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveProductRequest;
use App\Models\Product;
use App\DTO\ProductData;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AdminProductController extends Controller
{
    public function __construct(
        private AdminProductServiceInterface $adminProductService,
        private ProductRepositoryInterface $productRepository
    ) {}

    public function index(): View
    {
        $products = $this->adminProductService->getAllProducts();
        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $data = $this->adminProductService->getDataForCreateView();
        return view('admin.products.create_update', $data);
    }

    public function store(SaveProductRequest $request): RedirectResponse
    {
        $productData = ProductData::from($request->validated())->toArray();
        $product = $this->productRepository->createProduct($productData);
        $this->adminProductService->syncServicesToProduct($product, $productData['services'] ?? []);

        return redirect()->route('admin.products.index')->with('success', 'Продукт успешно создан.');
    }

    public function edit(Product $product): View
    {
        $data = $this->adminProductService->getDataForEditView($product);
        return view('admin.products.create_update', $data);
    }

    public function update(SaveProductRequest $request, Product $product): RedirectResponse
    {
        $productData = ProductData::from($request->validated())->toArray();
        $this->productRepository->updateProduct($product, $productData);
        $this->adminProductService->syncServicesToProduct($product, $productData['services'] ?? []);

        return redirect()->route('admin.products.index')->with('success', 'Продукт успешно обновлен.');
    }

    public function delete(Product $product): RedirectResponse
    {
        $this->productRepository->deleteProduct($product);
        return redirect()->route('admin.products.index')->with('success', 'Продукт успешно удален.');
    }

    public function exportProductsToCsv(): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->adminProductService->exportProductsToCsv($user);
        return redirect()->back()->with('success', 'Отчет отправлен в обработку.');
    }
}
