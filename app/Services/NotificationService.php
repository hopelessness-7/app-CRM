<?php

namespace App\Services;

use App\Repositories\Eloquent\NotificationRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationService
{
    protected NotificationRepository $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function index($paginate): LengthAwarePaginator
    {
        return $this->notificationRepository->where($this->notificationRepository->getNotifiableConditions())->paginate($paginate);
    }

    public function show($id): Model
    {
        return $this->notificationRepository->where($this->notificationRepository->getNotifiableConditions())->find($id);
    }
}
