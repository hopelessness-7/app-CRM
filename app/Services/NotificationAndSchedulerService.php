<?php

namespace App\Services;

use App\Events\NotificationEvent;
use App\Events\SchedulerEvent;
use App\Models\Scheduler;
use App\Models\User;
use App\Repositories\Eloquent\NotificationRepository;
use App\Repositories\Eloquent\SchedulerRepository;
use Illuminate\Database\Eloquent\Model;

class NotificationAndSchedulerService
{
    protected SchedulerRepository $schedulerRepository;
    protected NotificationRepository $notificationRepository;

    public function __construct(SchedulerRepository $schedulerRepository, NotificationRepository $notificationRepository)
    {
        $this->schedulerRepository = $schedulerRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function sendNotification(User $user, array $data = []): void
    {
        $notification = $this->notificationRepository->create([
            'data' => json_encode($data),
            'notifiable_id' => $user->id,
            'notifiable_type' => get_class($user),
        ]);

        $this->sendRealTimeUpdate($user->id, ['id' => $notification->id, 'data' => json_decode($notification->data)], NotificationEvent::class);
    }

    public function addEventToScheduler(int $userId, string $title, string $label, ?string $start_date = null, ?string $end_date = null, bool $allDay = false): void
    {
        if (!in_array($label, Scheduler::$labels, true)) {
            throw new \InvalidArgumentException("Invalid label: '{$label}'. Allowed labels are: " . implode(', ', Scheduler::$labels));
        }

        if (!$allDay && (!$start_date || !$end_date)) {
            throw new \InvalidArgumentException("Either 'allDay' must be true or both 'start_date' and 'end_date' must be provided.");
        }

        if ($start_date && !strtotime($start_date)) {
            throw new \InvalidArgumentException("Invalid 'start_date' format. Use a valid date format (e.g., YYYY-MM-DD HH:MM:SS).");
        }

        if ($end_date && !strtotime($end_date)) {
            throw new \InvalidArgumentException("Invalid 'end_date' format. Use a valid date format (e.g., YYYY-MM-DD HH:MM:SS).");
        }

        $scheduler = $this->schedulerRepository->create([
            'user_id' => $userId,
            'title' => $title,
            'label' => $label,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'all_day' => $allDay,
        ]);

        $this->sendRealTimeUpdate($userId, $scheduler, SchedulerEvent::class);
    }

    protected function sendRealTimeUpdate(int $userId, array $data, string $classEvent): void
    {
        try {
            $event = app($classEvent, ['userId' => $userId, 'data' => $data]);
            broadcast($event);
        } catch (\Exception $e) {
            \Log::error('Failed to send real-time update', [
                'user_id' => $userId,
                'event' => $classEvent,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
