<?php

namespace App\Actions\vendors;

use App\Models\Vendor;
use App\Models\Product;
use App\Events\ProductCreated;

final class CreateProductAction
{
    public function __invoke(Vendor $vendor, array $data): Product
    {
        $product = $vendor->products()->create([
            'title' => $data['title']
        ]);

        event(new ProductCreated($product));
        return $product;
    }
}
