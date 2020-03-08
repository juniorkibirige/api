<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use App\Transformers\ProductTransformer;
use App\Actions\vendors\CreateProductAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Vendor;

class ProductsController extends Controller
{

    /**
     * List.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Vendor $vendor)
    {
        try {
            return fractal()->collection($vendor->products, new ProductTransformer());
        } catch (\Exception $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param CreateUserAction $createUserAction
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CreateProductAction $createProductAction, Vendor $vendor)
    {
        try {
            $product = $createProductAction($vendor, $request->all());
            return fractal()->item($product, new ProductTransformer())->respond(Response::HTTP_CREATED);
        } catch (\Exception $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

}
