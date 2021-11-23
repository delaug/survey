<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\RegisterAuthRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param RegisterAuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterAuthRequest $request) {
        $input = $request->validated();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        // Role & Token
        $user->roles()->attach(Role::IS_USER);
        $token = $user->createToken($input['device_name'])->plainTextToken;

        return response()->json(['token' => $token, 'user' => User::with(['roles'])->find($user->id)], Response::HTTP_OK);
    }


    /**
     * @param LoginAuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginAuthRequest $request) {
        $input = $request->validated();

        $user = User::with(['roles'])->where('email', $input['email'])->first();

        if (!$user || !Hash::check($input['password'], $user['password'])) {
            return response()->json(['error' => 'The provided credentials are incorrect.'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json(['token' => $user->createToken($input['device_name'])->plainTextToken, 'user' => $user]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['status' => 'ok'], Response::HTTP_OK);
    }
}
