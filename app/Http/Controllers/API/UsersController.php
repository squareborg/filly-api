<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use \League\Fractal\Pagination\IlluminatePaginatorAdapter;

use App\Models\User;
use App\Events\Auth\UserRequestedActivationEmail;
use App\Transformers\UserTransformer;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class UsersController extends Controller
{
    use AuthenticatesUsers;

    const PAGINATE_PER_PAGE = 10;

    public function index(Request $request)
    {
        $users = User::orderBy('first_name', 'asc')->paginate(self::PAGINATE_PER_PAGE);

        return fractal()->collection($users)
            ->parseIncludes(['roles'])
            ->transformWith(new UserTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($users));
    }

    public function create(Request $request)
    {
        try {
            $user = User::create($request->input());
            $user->syncRoles($request->input('roles'));
            $user->save();
            return fractal()->item($user)
                ->parseIncludes(['profile', 'permissions', 'roles'])
                ->transformWith(new UserTransformer)
                ->toArray();

        } catch (\Exception $e) {
            return response()
                ->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }


    public function show($id)
    {
        $user = User::findOrFail($id);
        return fractal()->item($user)
            ->parseIncludes(['profile', 'permissions', 'roles'])
            ->transformWith(new UserTransformer)
            ->toArray();
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = User::find($id);
            $user->update($request->input());
            $user->syncRoles($request->input('roles'));
            $user->save();
            return response()
                ->json(null, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()
                ->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        $user = User::findorFail($id);
        $user->delete();

        return response()->json([
            'message' => 'User was deleted',
        ]);
    }

}
