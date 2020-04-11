<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Transformers\ProductTransformer;
use App\Models\Product;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class ProductsController extends Controller
{

    /**
     * List.
     *
     * @param Request $request
     * @return \Spatie\Fractal\Fractal
     */
    public function index(Request $request)
    {
        if($request->user()->hasRole('admin')) {
            $paginator = Product::paginate();
        } else {
            $paginator = $request->user()->vendor->products()->paginate();
        }

        return fractal()
            ->collection($paginator, new ProductTransformer())
            ->paginateWith(new IlluminatePaginatorAdapter($paginator));

    }

}
