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

    /** @test */
    public function it_lists_a_users_products()
    {
        $paginateLength = 15;
        $vendor = factory(Vendor::class)->create();
        $products = factory(Product::class,30)->create([
            'vendor_id' => $vendor->id
        ]);
        $response = $this->actingAs($vendor->user, 'api')->get(route('products.index'));
        $response->assertOk();
        $data = $response->json()['data'];
        foreach($data as $product) {
            $this->assertEquals($product['vendor_id'], $vendor->id);
        }
        $this->assertCount($paginateLength, $data);
    }

    /** @test */
    public function it_does_not_list_other_vendors_products_to_non_admins()
    {
        $otherVendor = factory(Vendor::class)->create();
        $products = factory(Product::class,30)->create([
            'vendor_id' => $otherVendor->id
        ]);
        $vendor = factory(Vendor::class)->create();
        
        $response = $this->actingAs($vendor->user, 'api')->get(route('products.index'));
        $data = $response->json()['data'];
        foreach($data as $product) {
            $this->assertEquals($product['vendor_id'], $vendor->id);
        }
        $this->assertCount(0, $data);
    }

    /** @test */
    public function it_lists_all_vendors_products_to_admins()
    {
        $admin = $this->createAdminApiUser();
        factory(Product::class,15)->create();
                
        $response = $this->actingAs($admin, 'api')->get(route('products.index'));
        $data = $response->json()['data'];
        $this->assertCount(15, $data);
    }
}


