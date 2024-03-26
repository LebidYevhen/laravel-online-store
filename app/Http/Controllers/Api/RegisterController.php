<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'name' => ['required', 'string', 'max:255'],
          'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
          'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            return response()->json(
              [
                'success' => false,
                'message' => 'Validation failed.',
                'fails' => $validator->errors()
              ], 401);
        }

        $user = User::create([
          'name' => $request->name,
          'email' => $request->email,
          'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        $token = $user->createToken(
          'UserAccessToken',
          ['*'],
          now()->addWeek()
        )->plainTextToken;

        return response()->json(
          [
            'success' => true,
            'user_id' => $user->id,
            'message' => 'New user successfully registered.',
            'token' => $token
          ], 200);
    }
}
