<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveProductRequest;
use App\Models\Service;
use App\Models\Product;
use App\Contracts\RepositoryInterface;
use App\Jobs\ExportAndSendReport;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with(['brand', 'services'])->get();
        return view('admin.products.index', ['products' => $products]);
    }

    public function create(): View
    {
        $services = Service::all();
        $fields = config('productForm.fields');
        return view('admin.products.create_update', ['services' => $services, 'fields' => $fields]);
    }

    public function store(RepositoryInterface $productRepository, SaveProductRequest $request): RedirectResponse
    {
        $product = $productRepository->createProduct($request->only(
            'name',
            'brand',
            'link',
            'description',
            'release_date',
            'price'
        ));

        $services = $request->input('services');
        $product->services()->attach($services, [
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('admin.products.index')->with('success', 'Продукт успешно создан.');
    }

    public function edit(Product $product): View
    {
        $services = Service::all();
        $product->load('services');
        $selectedServices = $product->services->pluck('id')->toArray();
        $fields = config('productForm.fields');
        return view('admin.products.create_update', [
            'product' => $product,
            'services' => $services,
            'selectedServices' => $selectedServices,
            'fields' => $fields
        ]);
    }

    public function update(
        RepositoryInterface $productRepository,
        SaveProductRequest $request,
        Product $product
    ): RedirectResponse {
        $productRepository->updateProduct($product, $request->only(
            'name',
            'brand',
            'link',
            'description',
            'release_date',
            'price'
        ));
        $product->services()->sync($request->input('services'));
        return redirect()->route('admin.products.index')->with('success', 'Продукт успешно обновлен.');
    }

    public function delete(RepositoryInterface $productRepository, Product $product): RedirectResponse
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
