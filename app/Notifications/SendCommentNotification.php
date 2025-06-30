<?php

namespace App\Notifications;

use App\Models\User;
use App\ValueObject\NotificationData;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public User $user,
        public NotificationData $data
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->data->title)
            ->line($this->data->description);
    }

    public function toDatabase(object $notifiable): DatabaseMessage
    {
        return new DatabaseMessage($this->data->toArray());
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('notification.'.$this->user->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'notification';
    }

    public function toBroadcast(object $notifiable): DatabaseMessage
    {
        return new DatabaseMessage($this->data->toArray());
    }
}
