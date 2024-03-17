<?php

namespace App\Http\Controllers\ApiV1\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Notifications\NewDeviceLoginNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends AuthController
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        // получаем устройство и айпишник пользователя
        $currentDevice = $request->userAgent();
        $userIp = $request->ip();
        $credentials = $request->only('email', 'password');

        // проверка на то, что правильно введены ли данные пользователя
        if (!$token = auth()->attempt($credentials)) {
            // если пароль и мыло не правильные, то отдаём ошибку
            return  $this->sendError('Authorization error check the entered data', 403);
        }

        //если данные правильные, то получаем авторизированного пользователя
        $user = Auth::user();

        // получаем дейвас пользователя с которого он зашёл
        $existingDevice = $user->devices()->where('device', $currentDevice)->first();

        // если устройство не найдено, то создаем новое со статусом по умолчанию 0, то есть не потврежденное устройство
        if (!$existingDevice) {
            $user->devices()->create([
                'device' => $currentDevice,
                'device_ip' => $userIp
            ]);

            // код повреждения, которе будет отправлено на почту
            $confirmationCode = random_int(100000, 999999);

            // отправляем уведомление на почту с кодом
            $user->notify(new NewDeviceLoginNotification($confirmationCode));

            // отдаем ошибку о том, что пользователь вошёл с новым кодам и ему нужно его потвердить
            return $this->sendError(['message' => 'Authorization from a new device, we have sent you an email with a code to confirm authorization', 'user' => $user->id], 409);
        }

        // если пользователь попытается снова зайти на новое устройство
        if ($existingDevice->status == 0) {
            return $this->sendError('the device is not confirmed, a message has been sent to the mail', 403);
        }

        $message = 'Authorization was successful';

        if (auth()->user()->email_verified_at == null) {
            return $this->sendError('The email address is not confirmed, send it to the mail and confirm it. If you do not receive a message, then send a second email', 403);
        }

        // если всё окей отдаём данные пользователя
        return $this->sendResponse([$this->createNewToken($token)], $message);

    }
}
