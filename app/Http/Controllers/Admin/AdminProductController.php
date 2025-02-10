<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Contracts\AdminProductServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveProductRequest;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AdminProductController extends Controller
{
    public function __construct(private AdminProductServiceInterface $adminProductService)
    {
    }

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
        $data = $request->only('name', 'brand_id', 'category_id', 'description', 'release_date', 'price');
        $product = $this->adminProductService->addNewProduct($data);
        $this->adminProductService->syncServicesToProduct($product, $request->input('services') ?? []);

        return redirect()->route('admin.products.index')->with('success', 'Продукт успешно создан.');
    }

    public function edit(Product $product): View
    {
        $data = $this->adminProductService->getDataForEditView($product);
        return view('admin.products.create_update', $data);
    }

    public function update(SaveProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->only('name', 'brand_id', 'category_id', 'description', 'release_date', 'price');
        $this->adminProductService->updateProduct($product, $data);
        $this->adminProductService->syncServicesToProduct($product, $request->input('services') ?? []);

        return redirect()->route('admin.products.index')->with('success', 'Продукт успешно обновлен.');
    }

    public function delete(Product $product): RedirectResponse
    {
        $this->adminProductService->deleteProduct($product);
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
