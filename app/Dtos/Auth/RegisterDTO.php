<?php

namespace App\Dtos\Auth;

use App\Dtos\BaseDTO;
use App\Enums\LoginType;

class RegisterDTO extends BaseDTO
{
    public function __construct(
        public string $name,
        public string|null $phone,
        public string|null $email,
        public string $password,
        public LoginType $loginType
    ) {
    }

    public static function fromRequest(array $data): static
    {
        return new self(
            $data['name'],
            $data['phone'] ?? null,
            $data['email'] ?? null,
            $data['password'],
            LoginType::from($data['login_type'])
        );
    }
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => $this->password,
            'login_type' => $this->loginType
        ];
    }
}
