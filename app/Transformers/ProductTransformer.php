<?php

namespace App\Transformers;

use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param User $user
     * @return array
     */
    public function transform(Product $data)
    {
        return [
            'id' => $data->id,
            'title' => $data->title,
            'vendor_id' => $data->vendor_id,
            'price' => "£".number_format(($data->price /100), 2, '.', ' ')
        ];
    }
}
