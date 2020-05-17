<?php

namespace App\Transformers;

use App\Models\Products\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Product $data
     * @return array
     */
    public function transform(Product $data)
    {
        return [
            'id' => $data->id,
            'name' => $data->name,
            'description' => $data->description,
            'vendor_id' => $data->vendor_id,
            'price' => $data->price,
            'formatted_price' => '£' . number_format($data->price / 100, 2)
        ];
    }
}
