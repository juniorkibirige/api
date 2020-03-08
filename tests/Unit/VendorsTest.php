<?php

namespace Tests\Unit;

use App\Models\Vendor;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModulesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function it_stores_a_vendor()
    {
        $user = $this->createApiUser();
        $vendor = factory(Vendor::class)->make();
        $data = [
            'name' => $vendor->name
        ];
        $response = $this->actingAs($user, 'api')->post(route('vendors.store'), $data);
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('vendors', [
            'name' => $vendor->name,
            'user_id' => $user->id
        ]);

    }

}
