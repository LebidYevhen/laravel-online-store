<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
          'email' => ['required', 'string', 'email'],
          'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(
              [
                'success' => false,
                'message' => 'Validation failed',
                'fails' => $validator->errors()
              ], 401);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
              'success' => false,
              'message' => 'The provided credentials do not match our records.'
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken(
          'UserAccessToken',
          ['*'],
          now()->addWeek()
        )->plainTextToken;

        return response()->json(
          [
            'success' => true,
            'message' => 'The user has successfully logged in.',
            'token' => $token
          ], 200);
    }
}
