<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \League\Fractal\Pagination\IlluminatePaginatorAdapter;
use App\Transformers\RoleTransformer;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    const PAGINATE_PER_PAGE = 10;

    public function index(Request $request)
    {
        // @todo sm should cache this as it will rarely change
        $roles = Role::orderBy('name', 'asc')->paginate(self::PAGINATE_PER_PAGE);

        return fractal()->collection($roles)
            ->transformWith(new RoleTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($roles));
    }

}
