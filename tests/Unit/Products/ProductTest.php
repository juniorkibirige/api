<?php

namespace Tests\Unit;

use App\Events\ProductCreated;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Vendor;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function it_stores_a_product()
    {
        Event::fake('App\Events\ProductCreated');

        $vendor = factory(Vendor::class)->create();
        $product = factory(Product::class)->make();
        $data = [
            'name' => $product->name
        ];

        $response = $this->actingAs($vendor->user, 'api')->post(route('products.store', $vendor), $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('products', [
            'name' => $product->name,
            'vendor_id' => $vendor->id
        ]);
        Event::assertDispatched(ProductCreated::class, function ($e) use ($response) {
            return $e->product->id === $response->json()['id'];
        });
    }
}


