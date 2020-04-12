<?php

namespace App\Transformers;

use App\Models\Product;
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
            'vendor_id' => $data->vendor_id,
            'price' => "£".number_format(($data->price /100), 2, '.', ' ')
        ];
    }
}
