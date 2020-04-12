<?php

namespace App\DTO\Vendors\Products;

use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Http\Request;

class ProductData extends DataTransferObject
{
    /** @var string */
    public $name;

    /** @var int */
    public $price;

    public static function fromRequest(Request $request)
    {
        return new self([
            'name' => $request->get('name'),
            'price' => $request->get('price')
        ]);
    }
}
