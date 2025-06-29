<?php

namespace App\Services\Internal;

use App\Dtos\Auth\LoginDTO;
use App\Dtos\Auth\RegisterDTO;
use App\Enums\ErrorMessages;
use App\Enums\LoginType;
use App\Exceptions\EmailRequiredException;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\PhoneRequiredException;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function register(RegisterDTO $data): User
    {
        if ($data->loginType === LoginType::EMAIL && $data->email === null) {
            throw new EmailRequiredException();
        }
        if ($data->loginType === LoginType::PHONE && $data->phone === null) {
            throw new PhoneRequiredException();
        }

        if ($data->loginType === LoginType::EMAIL) {
            $data->phone = null;
        }

        if ($data->loginType === LoginType::PHONE) {
            $data->email = null;
        }

        return User::create($data->toArray());
    }

    public function login(LoginDTO $data)
    {
        if ($data->loginType === LoginType::EMAIL && $data->email === null) {
            throw new EmailRequiredException();
        }
        if ($data->loginType === LoginType::PHONE && $data->phone === null) {
            throw new PhoneRequiredException();
        }
        if ($data->loginType === LoginType::EMAIL) {
            $data->phone = null;
        }

        if ($data->loginType === LoginType::PHONE) {
            $data->email = null;
        }
        if (!Auth::attempt($data->toArray())) {
            throw new InvalidCredentialsException();
        }

        $user = Auth::user();

        return [
            'token' => $user->createToken($user->email)->plainTextToken,
            'user' => UserResource::make($user)
        ];
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
    }

}
