<?php

namespace App\Models;

use App\Enums\VerificationCodeType;

class VerificationCode extends BaseModel
{
    protected $fillable = [
        'user_id',
        'type',
        'value',
        'code',
        'verified',
        'expires_at',
    ];

    protected function casts()
    {
        return [
            'verified' => 'boolean',
            'expires_at' => 'datetime',
            'type' => VerificationCodeType::class,
        ];

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
