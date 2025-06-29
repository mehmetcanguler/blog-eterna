<?php

namespace App\Http\Resources;

use App\Enums\LoginType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->when($this->login_type === LoginType::EMAIL, $this->email),
            'phone' => $this->when($this->login_type === LoginType::PHONE, $this->phone),
        ];
    }
}
