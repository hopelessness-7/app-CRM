<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDeviceNotification extends Notification
{
    public function __construct()
    {
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Hello,')
            ->line('You have added a new device to your account. It is accessible in your profile settings.')
            ->line('If you did not perform this action, please change your password immediately and remove this device.')
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'Title' => 'Security Notification',
            'message' => "You have logged in from a new device, check your personal account in the settings section, as well as your email. If you didn't do it, then change the password and delete the new device as a matter of urgency!"
        ];
    }
}
