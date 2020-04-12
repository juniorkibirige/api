<?php

namespace App\Http\Controllers;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\ProductTransformer;
use App\Models\Product;
use App\DTO\Vendors\Products\ProductData;
use App\Actions\Vendors\Products\UpdateProductAction;

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

     /**
     * List.
     *
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product, UpdateProductAction $updateProductAction)
    {
        return fractal()->item($updateProductAction(ProductData::fromRequest($request), $product))
            ->transformWith(new ProductTransformer)->respond();
    }

}
