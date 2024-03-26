<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LogoutController extends Controller
{
    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([
          'success' => true,
          'message' => 'User is logged out successfully.'
        ], 200);
    }
}
