<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\v1\LoginUser;
use App\Actions\v1\RegisterUser;
use App\DTOs\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        if ($request->is_admin) {
            (auth()->user()?->is_admin !== true) ? $request->is_admin = false : '';
        }

        $payload = RegisterUser::run(UserDTO::fromRequest($request));
        if (is_null($payload)) {
            return response()->json(['message' => 'Could not create user'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'user' => $payload['user'],
            'token' => $payload['token'],
        ], Response::HTTP_CREATED);
    }

    public function login(LoginUserRequest $request)
    {
        $payload = LoginUser::run($request->validated());

        if (is_null($payload)) {
            return response()->json(['message' => 'Credentials dont matches'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'user' => $payload['user'],
            'token' => $payload['token'],
        ], Response::HTTP_OK);
    }
}
