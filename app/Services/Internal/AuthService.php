<?php

namespace App\Services\Internal;

use App\Dtos\Auth\LoginDTO;
use App\Dtos\Auth\RegisterDTO;
use App\Enums\LoginType;
use App\Enums\RoleEnum;
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
        if ($data->login_type === LoginType::EMAIL && $data->email === null) {
            throw new EmailRequiredException;
        }
        if ($data->login_type === LoginType::PHONE && $data->phone === null) {
            throw new PhoneRequiredException;
        }

        $user = User::create($data->toArray());

        $role = match ($data->role_type) {
            RoleEnum::AUTHOR => RoleEnum::AUTHOR,
            RoleEnum::USER => RoleEnum::USER,
        };

        $user->assignRole($role->value);

        return $user;
    }

    public function login(LoginDTO $data)
    {
        if ($data->login_type === LoginType::EMAIL && $data->email === null) {
            throw new EmailRequiredException;
        }
        if ($data->login_type === LoginType::PHONE && $data->phone === null) {
            throw new PhoneRequiredException;
        }
        if ($data->login_type === LoginType::EMAIL) {
            $data->phone = null;
        }

        if ($data->login_type === LoginType::PHONE) {
            $data->email = null;
        }

        if (!Auth::attempt($data->toArray())) {
            throw new InvalidCredentialsException;
        }

        $user = Auth::user();

        return [
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => UserResource::make($user),
        ];
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
    }
}
