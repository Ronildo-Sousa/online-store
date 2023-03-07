<?php

namespace App\Actions\v1;

use App\DTOs\UserDTO;
use App\Models\User;

class RegisterUser
{
    public static function run(UserDTO $userDto)
    {
        $user = User::query()
            ->create($userDto->toArray());
        $token = $user->handleTokens();

        return [
            'user' => $user,
            'token' => $token
        ];
    }
}
