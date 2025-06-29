<?php

namespace App\Dtos\Auth;

use App\Dtos\BaseDTO;
use App\Enums\LoginType;

class LoginDTO extends BaseDTO
{
    public function __construct(
        public ?string $phone,
        public ?string $email,
        public string $password,
        public LoginType $loginType
    ) {
    }

    public static function fromRequest(array $data): static
    {
        return new self(
            email: $data['email'] ?? null,
            phone: $data['phone'] ?? null,
            password: $data['password'],
            loginType: LoginType::from($data['login_type'])
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
            'login_type' => $this->loginType,
        ];
    }
}
