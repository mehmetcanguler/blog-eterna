<?php

namespace App\Http\Requests\Auth;

use App\Dtos\Auth\LoginDTO;
use App\Enums\LoginType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class LoginRequest extends FormRequest
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
            'email' => 'nullable|required_without:phone|email|max:255',
            'phone' => 'nullable|required_without:email|max:13',
            'password' => 'required|max:255',
            'login_type' => [
                'required',
                new Enum(LoginType::class),
            ],

        ];
    }

    public function attributes(): array
    {
        return [
            'email' => trans('attributes.email'),
            'phone' => trans('attributes.phone'),
            'password' => trans('attributes.password'),
            'login_type' => trans('attributes.login_type'),

        ];
    }

    public function toDto(): LoginDTO
    {
        return LoginDTO::fromRequest($this->validated());
    }
}
