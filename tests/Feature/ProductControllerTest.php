<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Support\Arr;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    private array $testData = [
        'name' => 'New product',
        'brand' => 'Some brand',
        'link' => 'images/product_1.jpg',
        'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Vitae, modi.',
        'release_date' => '2024-01-01',
        'price' => 10.99,
        'services' => [1, 2]
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    #[Test]
    public function it_shows_products_in_admin_pannel(): void
    {
        $response = $this->get(route('admin.products.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.products.index');
        $products = Product::all();
        $response->assertViewHas('products', $products);
        $this->assertCount($products->count(), $response->viewData('products'));
    }

    #[Test]
    public function it_creates_new_product_with_services(): void
    {
        $response = $this->post(route('admin.products.store'), $this->testData);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', Arr::except($this->testData, ['services']));
        $product = Product::where('name', $this->testData['name'])->first();

        if ($product) {
            foreach ($this->testData['services'] as $serviceId) {
                $this->assertDatabaseHas('products_services', [
                    'product_id' => $product->id,
                    'service_id' => $serviceId
                ]);
            }
        } else {
            $this->fail('Product was not created.');
        }
    }

    #[Test]
    public function it_updates_existing_product(): void
    {
        $existingProduct = Product::where('name', 'Телевизор')->first();

        $this->assertNotNull($existingProduct, 'Product does not exist.');

        $response = $this->put(route('admin.products.update', $existingProduct->id), $this->testData);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $existingProduct->id,
            'name' => $this->testData['name'],
            'brand' => $this->testData['brand'],
            'link' => $this->testData['link'],
            'description' => $this->testData['description'],
            'release_date' => $this->testData['release_date'],
            'price' => $this->testData['price'],
        ]);
    }

    #[Test]
    public function it_delete_existing_product(): void
    {
        $existingProduct = Product::where('name', 'Телевизор')->first();

        $this->assertNotNull($existingProduct, 'Product does not exist.');

        $response = $this->delete(route('admin.products.delete', $existingProduct->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseMissing('products', [
            'id' => $existingProduct->id,
            'name' => 'Телевизор'
        ]);
    }
}
