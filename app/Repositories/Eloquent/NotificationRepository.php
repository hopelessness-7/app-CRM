<?php

namespace App\Repositories\Eloquent;

use App\Models\Notification;

class NotificationRepository extends RepositoryBase
{
    public function __construct(Notification $notification)
    {
        parent::__construct($notification);
    }

    public function getNotifiableConditions(): array
    {
        return [
            'notifiable_id' => auth()->id(),
            'notifiable_type' => get_class(auth()->user()),
        ];
    }
}
