<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_a_product()
    {
        $product = Product::create([
            'name' => 'Test Product',
            'description' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quasi, cumque.',
            'brand' => 'Test brand',
            'release_date' => '2024-01-01',
            'price' => 100.00,
            'link' => 'http://test.com'
        ]);

        $this->assertEquals('Test Product', $product->name);
    }

    #[Test]
    public function it_has_a_many_to_many_relationship_with_services()
    {
        $product = Product::create([
            'name' => 'Test Product',
            'description' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quasi, cumque.',
            'brand' => 'Test brand',
            'release_date' => '2024-01-01',
            'price' => 100.00,
            'link' => 'http://test.com'
        ]);

        $service = Service::create([
            'name' => 'Test Service',
            'duration' => 3,
            'price' => 10.00
        ]);

        $product->services()->attach($service->id);

        $this->assertTrue($product->services->contains($service));
    }
}
