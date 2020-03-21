<?php

namespace Tests\Unit;

use App\Models\Setting;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Vendor;

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

    /**  @test */
    public function new_vendors_respect_the_auto_enable_setting()
    {
        $user = $this->createApiUser();

        Setting::updateOrCreate(
            ['key' => 'vendor_auto_enable'],
            ['value' => true]
        );

        $vendor = factory(Vendor::class)->make();
        $data = [
            'name' => $vendor->name
        ];

        $response = $this->actingAs($user, 'api')->post(route('vendors.store'), $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('vendors', [
            'name' => $vendor->name,
            'user_id' => $user->id,
            'is_active' => true,
        ]);

        Setting::updateOrCreate(
            ['key' => 'vendor_auto_enable'],
            ['value' => false]
        );

        $response = $this->actingAs($user, 'api')->post(route('vendors.store'), $data);
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('vendors', [
            'name' => $vendor->name,
            'user_id' => $user->id,
            'is_active' => false,
        ]);

    }
}


