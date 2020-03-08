<?php

namespace App\Actions\vendors;

use App\Models\Vendor;
use App\Events\VendorCreated;

final class CreateVendorAction
{
    public function __invoke(array $vendorData): vendor
    {
        $vendor = auth()->user()->vendors()->create([
            'name' => $vendorData['name'],
            'tagline' => $vendorData['tagline'],
        ]);

        event(new VendorCreated($vendor));
        return $vendor;
    }
}
