<?php

namespace App\Http\Controllers\Vendors;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\ProductTransformer;
use App\Actions\vendors\CreateProductAction;
use App\Models\Vendor;

class ProductsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param CreateProductAction $createProductAction
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, CreateProductAction $createProductAction, Vendor $vendor)
    {
            $product = $createProductAction($vendor, $request->all());
            return fractal()->item($product, new ProductTransformer())->respond(Response::HTTP_CREATED);
    }
}
