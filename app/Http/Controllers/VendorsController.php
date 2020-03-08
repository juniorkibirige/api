<?php

namespace App\Http\Controllers;

use App\DTO\VendorData;
use App\Http\Controllers\Controller;
use App\Transformers\VendorTransformer;
use App\Actions\vendors\CreateVendorAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Vendor;

class VendorsController extends Controller
{

    /**
     * List.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            return fractal()->collection(auth()->user()->vendors, new VendorTransformer());
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
    public function store(Request $request, CreateVendorAction $createVendorAction)
    {
        try {
            $vendor = $createVendorAction(VendorData::fromRequest($request));
            return fractal()->item($vendor, new VendorTransformer())->respond(Response::HTTP_CREATED);
        } catch (\Exception $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

}
