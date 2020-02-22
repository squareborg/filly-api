<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Transformers\ProgramMediaTransformer;
use App\Models\Program;
use App\Models\ProgramMedia;
use Symfony\Component\HttpFoundation\Response;
class ProgramMediaController extends Controller
{
    public function index(Request $request, Program $program)
    {
        return fractal()->collection($program->media)
            ->transformWith(new ProgramMediaTransformer);
    }

    public function destroy(Request $request, Program $program, ProgramMedia $programMedia)
    {
        $programMedia->delete();
        return response()->json([
            'message' => 'deleted'
        ], Response::HTTP_NO_CONTENT);
    }


}
