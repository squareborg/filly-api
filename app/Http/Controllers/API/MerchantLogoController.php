<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Transformers\ProgramMediaTransformer;
use App\Models\Program;
use App\Models\ProgramMedia;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Merchant;

class MerchantLogoController extends Controller
{

    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function index(Request $request, Program $program)
    {
        return fractal()->collection($program->media)
            ->transformWith(new ProgramMediaTransformer);
    }

    public function store(Request $request, Merchant $merchant)
    {
        try {
            $file = $request->file('logo');
            $logo = $this->mediaService->setMerchant($merchant)->storeLogo($file, $request->user(), 'logo');
            $merchant->update(['logo' => $logo, 'disk' => $this->mediaService->disk]);
        } catch (\Exception $e) {
            Log::error('[LOGO_UPDATE]', [$e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['logo' => Storage::url($logo)], Response::HTTP_CREATED);
    }

    public function destroy(Request $request, Program $program, Merchant $merchant)
    {
        Storage::delete($merchant->logo);
        $merchant->logo = null;
        $merchant->save();
        return response()->json([
            'message' => 'deleted'
        ], Response::HTTP_NO_CONTENT);
    }


}
