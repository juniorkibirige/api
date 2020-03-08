<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    /**
     * @test
     */
    public function it_stores_a_new_product()
    {
        $vendor = factory('App\Models\Vendor')->create();
        $this->actingAs($vendor->user, 'api');
        $response = $this->json('POST', route('products.store', ['vendor' => $vendor->id]), [
            'title' => 'Bobbies bits',
        ]);
        $response->assertStatus(201);
    }

    /**
     * @test
     */
    public function it_lists_a_paginated_list_of_products()
    {
        $vendor = factory('App\Models\Vendor')->create();
        $this->actingAs($vendor->user, 'api');
        $response = $this->json('GET', route('products.index', ['vendor' => $vendor->id]));
        $response->assertJsonStructure(
            ['data' => ['*' => []], 'meta' => [ '*' => []]
        ]);
        $response->assertStatus(200);
    }
}
