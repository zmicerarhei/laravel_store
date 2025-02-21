<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\ProductSeeder;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_gets_products_in_the_catalog(): void
    {
        $this->seed(ProductSeeder::class);

        $response = $this->get(route('client.products.index'));

        $response->assertStatus(200);
        $response->assertViewIs('catalog.index');
        $response->assertViewHas('products');
        $this->assertCount(12, $response->viewData('products'));
    }

    #[Test]
    public function it_shows_single_product(): void
    {
        $this->seed(ProductSeeder::class);
        $product = Product::first();

        $response = $this->get(route('client.products.show', $product));
        $response->assertStatus(200);
        $response->assertViewIs('catalog.show');
        $response->assertViewHas('product');
        $this->assertEquals($product->id, $response->viewData('product')->id);
    }
}
