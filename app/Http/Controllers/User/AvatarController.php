<?php

namespace App\Http\Controllers\User;

use App\Services\MediaService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class AvatarController extends Controller
{
    /**
     * @var MediaService
     */
    protected $mediaService;

    /**
     * @param MediaService $mediaService
     */
    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function update(Request $request)
    {
        try {
            $file = $request->file('avatar');
            $avatar = $this->mediaService->storeAvatar($file, $request->user(), 'avatar');
            $request->user()->update(['avatar' => $avatar]);
        } catch (\Exception $e) {
            Log::error('[AVATAR_UPDATE]', [$e->getMessage()]);
            return redirect()->back()->with('error', __('general.error'));
        }

        return redirect()->back()->with('success', trans('user.avatar.updated'));
    }
}
