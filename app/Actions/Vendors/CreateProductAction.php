<?php

namespace App\Actions\vendors;

use App\Models\Vendor;
use App\Models\Products\Product;
use App\Events\ProductCreated;

final class CreateProductAction
{
    public function __invoke(Vendor $vendor, array $data): Product
    {
        $product = $vendor->products()->create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        $product->variants()->create([
            'price' => $data['price']
        ]);

        event(new ProductCreated($product));
        return $product;
    }
}
