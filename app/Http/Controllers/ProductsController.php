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

        $query = Product::query();
        
        if ($request->has('s')) {
            $query->where('name', 'like', "%{$request->get('s')}%");
        }
        if(! $request->user()->hasRole('admin')) {
            $query->where('vendor_id', '=', $request->user()->vendor->id);
        }

        $paginator = $query->paginate();
        
        return fractal()
            ->collection($paginator->items(), new ProductTransformer())
            ->paginateWith(new IlluminatePaginatorAdapter($paginator));

    }

}
