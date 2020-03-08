<?php

namespace App\Http\Controllers\Users;

use App\DTO\PasswordData;
use App\Http\Controllers\Controller;
use App\Actions\Users\UpdatePasswordAction;
use App\Http\Requests\Users\PasswordRequest;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PasswordController extends Controller
{
    public function __invoke(PasswordRequest $request, UpdatePasswordAction $updatePasswordAction)
    {
        try {
            $updatePasswordAction($request->user(), PasswordData::fromRequest($request));
            return response()->json(null, Response::HTTP_OK);
        } catch (\Exception $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }
}
