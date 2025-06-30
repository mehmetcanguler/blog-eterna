<?php

namespace App\ValueObject;

use App\Enums\NotificationType;

class NotificationData extends BaseValueObjectData
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public NotificationType $type,
        public string $title,
        public string $description,
        public ?string $id
    ) {}

    public function toArray(): array
    {
        return [
            'notification_type' => $this->type->value,
            'title' => $this->title,
            'description' => $this->description,
            'id' => $this->id,
        ];
    }
}
