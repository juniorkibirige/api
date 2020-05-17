<?php

namespace App\Actions\Vendors\Products;

use App\DTO\Vendors\Products\ProductData;
use App\Models\Products\Product;
use App\Events\Vendors\Products\ProductUpdated;

final class UpdateProductAction
{
    public function __invoke(ProductData $productData, Product $product): product
    {
        $product->update([
            'name' => $productData->name,
            'description' => $productData->description
        ]);
        $product->variants()->first([
            'price' => $productData->price
        ]);
        event(new ProductUpdated($product));
        return $product->refresh();
    }
}
