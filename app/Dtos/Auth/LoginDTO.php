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
        public LoginType $login_type,

    ) {
    }

    public static function fromRequest(array $data): static
    {
        return new self(
            email: $data['email'] ?? null,
            phone: $data['phone'] ?? null,
            password: $data['password'],
            login_type: LoginType::from($data['login_type']),
        );
    }

    public function toArray(): array
    {
        $array = [
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
            'login_type' => $this->login_type,
        ];
        if($this->login_type === LoginType::EMAIL) {
           unset($array['phone']);
        }
        if($this->login_type === LoginType::PHONE) {
            unset($array['email']);
        }
        return $array;
    }
}
