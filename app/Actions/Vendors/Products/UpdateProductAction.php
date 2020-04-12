<?php

namespace App\Actions\Vendors\Products;

use App\DTO\Vendors\Products\ProductData;
use App\Models\Product;
use App\Events\Vendors\Products\ProductUpdated;

final class UpdateProductAction
{
    public function __invoke(ProductData $productData, Product $product): product
    {
        $product->update($productData->toArray());
        event(new ProductUpdated($product));
        return $product->refresh();
    }
}
