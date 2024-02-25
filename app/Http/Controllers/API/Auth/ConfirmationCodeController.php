<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use App\Notifications\NewDeviceLoginNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class ConfirmationCodeController extends AuthController
{
    public function confirmationCode(Request $request): JsonResponse
    {
        // получаем пользователя, его устройство и код подтверждения
        $user = User::find($request->user_id);
        $notification = $user->notifications()->where('type', \App\Notifications\NewDeviceLoginNotification::class)->orderBy('created_at', 'desc')->first();
        $currentDevice = $request->userAgent();

        // проверяем есть ли вообще уведомления с кодом
        if (!$notification) {
            return $this->sendError('Confirmation code not generated', 422);
        }

        // если уведомление есть в бд, то получаем его
        $confirmationCode = $notification->data['code'];

        // проверяем что у нас в бд и что отправил пользователь
        if ($request->confirmation_code != $confirmationCode) {
            return $this->sendError('Invalid confirmation code', 422);
        }

        // Проверяем, не истекло ли время действия кода (5 минут)
        $expiryTime = $notification->created_at->addMinutes(5);
        $currentTime = Carbon::now(); // Используем Carbon для получения текущего времени


        if (!$expiryTime->gt($currentTime)) {
            // если время истекло, то удаляем код.
            $notification->delete();
            return $this->sendError('The confirmation code has expired, send a new one, ', 422);
        }

        // после успешного ввода кода удаляем уведомление
        $notification->delete();

        // активируем устройство
        $device = $user->devices()->where('device', $currentDevice)->first();
        $device->status = 1;
        $device->save();

        // отдаем данные для авторизации
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'token' => JWTAuth::fromUser($user),
            
        ];

        $message = 'Authorization of the new device was successful';

        return $this->sendResponse($data, $message);
    }

    public function newConfirmationCode(Request $request):  JsonResponse
    {
        // Получаем пользователя и создаем новый код повреждения
        $user = User::find($request->user_id);
        $confirmationCode = random_int(100000, 999999);

        // отправляем код на почту
        $user->notify(new NewDeviceLoginNotification($confirmationCode));

        return $this->sendResponse([], 'A message with new codes has been sent');
    }
}
