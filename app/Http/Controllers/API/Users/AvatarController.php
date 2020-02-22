<?php

namespace App\Http\Controllers\API\User;

use App\Http\Requests\User\AvatarRequest;
use App\Services\MediaService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * Store the authenticated users avatar image
     *
     * @OA\Post(
     *     path="/user/avatar",
     *     tags={"User"},
     *     security={
     *      {"passport": {}},
     *     },
     *     @OA\Parameter(
     *          name="avatar",
     *          in="query",
     *          required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=201, description="Created"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable entity"),
     * )
     * @param AvatarRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AvatarRequest $request)
    {
        try {
            $file = $request->file('avatar');
            $avatar = $this->mediaService->storeAvatar($file, $request->user(), 'avatar');
            $request->user()->update(['avatar' => $avatar, 'disk' => $this->mediaService->getDisk()]);
        } catch (\Exception $e) {
            Log::error('[AVATAR_UPDATE]', [$e->getMessage()]);
            return redirect()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(['avatar' => $request->user()->realFullAvatarUrl], Response::HTTP_CREATED);
    }

    public function destroy(Request $request)
    {
        try {
            $user = auth()->user();
            $this->mediaService->setDisk($user->disk)->delete($user->avatar);
            $user->update(['avatar' => null, 'disk' => null]);
        } catch (\Exception $e) {
            Log::error('[AVATAR_UPDATE]', [$e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
