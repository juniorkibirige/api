<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\DTO\UserData;
use App\Http\Controllers\Controller;
use App\Transformers\UserTransformer;
use App\Actions\Users\CreateUserAction;
use App\Actions\Users\SuspendUserAction;
use App\Actions\Users\UnsuspendUserAction;
use App\Actions\Users\DeleteUserAction;
use App\Actions\Users\UpdateUserAction;
use App\Http\Requests\Users\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        try {
            $query = User::query();

            if ($request->has('s')) {
                $query->where('name', 'like', "%{$request->get('s')}%")
                    ->orWhere('email', 'like', "%{$request->get('s')}%");
            }

            $paginator = $query->latest()->paginate(self::PAGINATION_LIMIT);
            $users = $paginator->items();

            return fractal()->collection($users, new UserTransformer())
                ->parseIncludes(['roles'])
                ->paginateWith(new IlluminatePaginatorAdapter($paginator));
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
    public function store(Request $request, CreateUserAction $createUserAction)
    {
        try {
            $user = $createUserAction(UserData::fromRequest($request));
            return fractal()->item($user, new UserTransformer());
        } catch (\Exception $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return void
     */
    public function show(User $user)
    {
        try {
            return fractal()->item($user, new UserTransformer())
                ->parseIncludes(['roles', 'sites']);
        } catch (\Exception $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @param UpdateUserAction $updateUserAction
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, User $user, UpdateUserAction $updateUserAction)
    {
        try {
            if (! $request->has('email')) {
                $request->request->add(['email' => $user->email]);
            }
            $user = $updateUserAction($user, UserData::fromRequest($request));
            return fractal()->item($user, new UserTransformer());
        } catch (\Exception $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @param DeleteUserAction $updateUserAction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user, DeleteUserAction $deleteUserAction)
    {
        try {
            $deleteUserAction($user);
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Suspend the user.
     *
     * @param Request $request
     * @param User $user
     * @param SuspendUserAction $updateUserAction
     * @return \Illuminate\Http\Response
     */
    public function suspend(User $user, SuspendUserAction $suspendUserAction)
    {
        try {
            $user = $suspendUserAction($user);
            return fractal()->item($user, new UserTransformer());
        } catch (\Exception $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Unsuspend the user
     *
     * @param Request $request
     * @param User $user
     * @param UnuspendUserAction $updateUserAction
     * @return \Illuminate\Http\Response
     */
    public function unsuspend(User $user, UnsuspendUserAction $unuspendUserAction)
    {
        try {
            $user = $unuspendUserAction($user);
            return fractal()->item($user, new UserTransformer());
        } catch (\Exception $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }
}
