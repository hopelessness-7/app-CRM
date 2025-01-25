<?php

namespace App\Services\Auth;

use App\Notifications\NewDeviceLoginNotification;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use function Symfony\Component\Translation\t;

class CodeConfirmService
{
    protected UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->$userRepository = $userRepository;
    }
    public function confirmation($id, $currentDevice, $userRequestCode): array
    {
        // получаем пользователя, его устройство и код подтверждения
        $user = $this->userRepository->find($id);
        $notification = $user->notifications()->where('type', \App\Notifications\NewDeviceLoginNotification::class)
            ->orderBy('created_at', 'desc')->first();

        // проверяем есть ли вообще уведомления с кодом
        if (!$notification) {
            throw new \Exception('Confirmation code not generated', 422);
        }

        // если уведомление есть в бд, то получаем его
        $confirmationCode = $notification->data['code'];

        // проверяем что у нас в бд и что отправил пользователь
        if ($userRequestCode != $confirmationCode) {
            throw new \Exception('Invalid confirmation code', 422);
        }

        // Проверяем, не истекло ли время действия кода (5 минут)
        $expiryTime = $notification->created_at->addMinutes(5);
        $currentTime = Carbon::now(); // Используем Carbon для получения текущего времени


        if (!$expiryTime->gt($currentTime)) {
            // если время истекло, то удаляем код.
            $notification->delete();
            throw new \Exception('The confirmation code has expired, send a new one', 422);
        }

        // после успешного ввода кода удаляем уведомление
        $notification->delete();

        // активируем устройство
        $device = $user->devices()->where('device', $currentDevice)->first();
        $device->status = 1;
        $device->save();

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'token' => JWTAuth::fromUser($user),
        ];
    }

    public function newCode($id): void
    {
        $user = $this->userRepository->find($id);
        $confirmationCode = random_int(100000, 999999);
        $user->notify(new NewDeviceLoginNotification($confirmationCode));
    }
}
