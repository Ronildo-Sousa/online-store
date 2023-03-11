<?php

namespace App\Actions\v1;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginUser
{
    public static function run(array $credentials): ?array
    {
        if (Auth::attempt($credentials)) {
            $user = User::query()
                ->where('email', data_get($credentials, 'email'))
                ->first();

            $token = $user->handleTokens();

            return [
                'user' => $user,
                'token' => $token
            ];
        }
        return null;
    }
}
