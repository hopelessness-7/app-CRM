<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\MainController;
use App\Models\User;
use App\Notifications\NewDeviceLoginNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ConfirmationCodeController extends MainController
{
    public function confirmationCode(Request $request)
    {

        $user = User::find($request->user_id);
        $notification = $user->notifications()->where('type', \App\Notifications\NewDeviceLoginNotification::class)->orderBy('created_at', 'desc')->first();
        $currentDevice = $request->userAgent();

        if (!$notification) {
            return $this->sendError('Confirmation code not generated', 422);
        }

        $confirmationCode = $notification->data['code'];

        if ($request->confirmation_code != $confirmationCode) {
            return $this->sendError('Invalid confirmation code', 422);
        }

        // Проверяем, не истекло ли время действия кода (5 минут)
        $expiryTime = $notification->created_at->addMinutes(5);
        $currentTime = Carbon::now(); // Используем Carbon для получения текущего времени


        if (!$expiryTime->gt($currentTime)) {
            $notification->delete();
            return $this->sendError('The confirmation code has expired, send a new one, ', 422);
        }

        $notification->delete();

        $device = $user->devices()->where('device', $currentDevice)->first();
        $device->status = 1;
        $device->save();


        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'token' => $user->createToken($currentDevice)->plainTextToken,
        ];

        $message = 'Authorization of the new device was successful';

        return $this->sendResponse($data, $message);
    }

    public function newConfirmationCode(Request $request)
    {
        $user = User::find($request->user_id);
        $confirmationCode = random_int(100000, 999999);

        $user->notify(new NewDeviceLoginNotification($confirmationCode));

        return $this->sendResponse([], 'A message with new codes has been sent');
    }
}
