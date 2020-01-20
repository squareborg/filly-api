<?php

namespace App\Http\Controllers\API;

use App\Models\ProgramCategory;
use App\Setting;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use \League\Fractal\Pagination\IlluminatePaginatorAdapter;

use App\Events\Auth\UserRequestedActivationEmail;
use App\Transformers\ProgramTransformer;
use Illuminate\Foundation\Auth\Authenticatesprograms;
use Illuminate\Validation\Rule;
use jeremykenedy\LaravelRoles\Models\Role;
use Webpatser\Uuid\Uuid;

use App\Models\Program;
use App\Models\User;


class ProgramsController extends Controller
{
    const PAGINATE_PER_PAGE = 10;

    public function index(Request $request)
    {
        $query = Program::query();
        if (!$request->user()->hasRole('admin')){
            $query->where('approved','=', true);
            $query->whereIn('merchant_id', $request->user()->merchantSubscriptions->pluck('merchant_id'));

        }

        if($request->query('program_category_id')){
            $query->where('program_category_id', $request->query('program_category_id'));
        }
        $programs = $query->paginate(10);
        return fractal()->collection($programs)
            ->transformWith(new ProgramTransformer)
            ->parseIncludes('media')
            ->paginateWith(new IlluminatePaginatorAdapter($programs));
    }

    public function store(Request $request)
    {
        $auto_approve = Setting::where('key', 'program_auto_approve')->first();
        $approve = filter_var($auto_approve->value, FILTER_VALIDATE_BOOLEAN);
        $program = new Program;
        $program->name = $request->name;
        $program->uuid = Uuid::generate(4);
        $program->merchant_id = $request->user()->merchant->id;
        $program->approved = $approve;
        $program->program_category_id = ProgramCategory::where('slug', 'other')->first()->id;
        $program->save();

        return fractal($program, new ProgramTransformer)->parseIncludes(['program_category']);
    }


    public function show(Program $program)
    {
        return fractal()->item($program)
            ->transformWith(new ProgramTransformer)
            ->parseIncludes(['media','program_category']);
    }

    public function update(Request $request, Program $program)
    {
        if ($request->has('program_reward')){
            if ($request->input('program_reward') !== $program->programReward){
                $program->programRewards()->create([
                    'percentage' => $request->input('program_reward')
                ]);
            }
        }
        $program->update($request->all());
        return fractal()->item($program)
            ->transformWith(new ProgramTransformer)
            ->parseIncludes('media');
    }

    public function destroy(Request $request, Program $program)
    {
        $program->delete();

        return response()->json([
            'message' => 'User was deleted',
        ]);
    }

}
