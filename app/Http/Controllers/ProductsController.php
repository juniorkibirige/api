<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Transformers\ProductTransformer;
use App\Actions\vendors\CreateProductAction;
use App\Models\Product;
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
    public function index(Request $request)
    {
        if($request->user()->hasRole('admin')) {
            $paginator = Product::paginate();
        } else {
            $paginator = $request->user()->vendor->products()->paginate();
        }
        try {
            return fractal()->collection($paginator, new ProductTransformer())->paginateWith(new IlluminatePaginatorAdapter($paginator));
        } catch (\Exception $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

}
