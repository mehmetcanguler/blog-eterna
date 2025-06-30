<?php

namespace App\Http\Requests\Auth;

use App\Dtos\Auth\RegisterDTO;
use App\Enums\LoginType;
use App\Enums\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required|max:13|unique:users',
            'password' => 'required|max:255|confirmed|min:8',
            'login_type' => [
                'required',
                new Enum(LoginType::class),
            ],
            'role_type' => [
                'required',
                (new Enum(RoleEnum::class))->except(RoleEnum::ADMIN),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => trans('attributes.name'),
            'email' => trans('attributes.email'),
            'phone' => trans('attributes.phone'),
            'password' => trans('attributes.password'),
            'login_type' => trans('attributes.login_type'),
            'role_type' => trans('attributes.role_type'),

        ];
    }

    public function toDto(): RegisterDTO
    {
        return RegisterDTO::fromRequest($this->validated());
    }
}
