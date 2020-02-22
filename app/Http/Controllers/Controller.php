<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function logExceptionAndRespond(\Exception $e, string $tag, $message = "")
    {
        Log::error($tag, [$e->getMessage()]);
        return $this->errorResponse($message);
    }

    public function errorResponse(string $message)
    {
        return response()->json(['message' => $message], Response::HTTP_BAD_REQUEST);
    }
}
