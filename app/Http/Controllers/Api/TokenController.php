<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function get(Request $request): JsonResponse
    {
        return response()->json([
          'success' => true,
          'token' => $request->bearerToken()
        ]);
    }
}
