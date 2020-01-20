<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Program;

class ProgramMediaUploadController extends Controller
{

    public function __invoke(Request $request, Program $program)
    {
        $this->validate($request, [
            'image' => 'required|image'
        ]);
        $media = $program->addMedia($request->file('image'));
        if($media){
            return response()->json([
                'image' => $media,
            ], 200);
        }
        else{
            return response()->json([
                'message' => "Something went wrong"
            ], 400);
        }

    }


}
