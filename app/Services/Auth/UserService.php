<?php

namespace App\Services\Auth;

use App\Action\ImageDownload;
use App\Action\ImageHandler;
use App\Models\User;
use App\Notifications\NewDeviceLoginNotification;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserService
{
    protected UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->$userRepository = $userRepository;
    }
    public function register(array $data): User
    {
        $user = $this->userRepository->create($data);
        event(new Registered($user));
        return $user;
    }

    public function login(array $data): array|\Exception
    {
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];

        // проверка на то, что правильно введены ли данные пользователя
        if (!$token = auth()->attempt($credentials)) {
            // если пароль и мыло не правильные, то отдаём ошибку
            throw new \Exception('Authorization error check the entered data', 403);
        }

        //если данные правильные, то получаем авторизированного пользователя
        $user = Auth::user();

        // получаем дейвас пользователя с которого он зашёл
        $existingDevice = $user->devices()->where('device', $data['currentDevice'])->first();

        // если устройство не найдено, то создаем новое со статусом по умолчанию 0, то есть не потврежденое устройство
        if (!$existingDevice) {
            $user->devices()->create([
                'device' => $data['currentDevice'],
                'device_ip' => $data['userIp']
            ]);

            // код повреждения, которе будет отправлено на почту
            $confirmationCode = random_int(100000, 999999);

            // отправляем уведомление на почту с кодом
            $user->notify(new NewDeviceLoginNotification($confirmationCode));

            // отдаем ошибку о том, что пользователь вошёл с новым кодам и ему нужно его потвердить
            return [
                'message' => 'Authorization from a new device, we have sent you an email with a code to confirm authorization',
                'user' => $user->id,
                'code' => 409,
                'token' => null,
            ];
        }

        // если пользователь попытается снова зайти на новое устройство
        if ($existingDevice->status == 0) {
            return [
                'message' => 'the device is not confirmed, a message has been sent to the mail',
                'user' => null,
                'code' => 403,
                'token' => null,
            ];
        }

        if (auth()->user()->email_verified_at == null) {
            return [
                'message' => 'The email address is not confirmed, send it to the mail and confirm it. If you do not receive a message, then send a second email',
                'user' => null,
                'code' => 403,
                'token' => null,
            ];
        }

        return [
            'message' => 'Authorization was successful',
            'user' => null,
            'code' => 200,
            'token' => $token,
        ];
    }

    public function show($id = null): Model
    {
        return $this->userRepository->find($id);
    }

    public function update($id, $userUpdate): Model
    {
        $user = $this->show($id);

        if (array_key_exists('avatar', $userUpdate)) {
            $oldAvatar = ImageHandler::get($user, 'image');
            $fileNameWithExtension = basename($oldAvatar);
            Storage::delete('public/users/avatar/', $fileNameWithExtension);
            ImageHandler::create($user, $userUpdate['avatar'], 'users/avatar/', 'image');
            unset($userUpdate['avatar']);
        }

        $this->userRepository->update($id, $userUpdate);
        $user->avatar = $user->images->where('type', 'image')->first();
        return $user;
    }
}
