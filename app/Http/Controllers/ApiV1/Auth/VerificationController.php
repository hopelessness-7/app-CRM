<?php

namespace App\Http\Controllers\ApiV1\Auth;

use App\Http\Controllers\MainController;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerificationController extends MainController
{
    /**
     * Instantiate a new VerificationController instance.
     */
    public function __construct()
    {
        $this->middleware('auth')->only('notice', 'resend');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Display an email verification notice.
     *
     * @return JsonResponse
     */
    public function notice(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? $this->sendResponse(['message' => 'Вы уже потвердели почту', 'status_verification' => true], '200') : $this->sendResponse(['message' => 'Сообщение отправлено', 'status_verification' => false], '200');
    }

    /**
     * User's email verificaiton.
     *
     * @param Request $request
//     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
    {
        $user = User::findOrFail($request->route('id'));

        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            return $this->sendError('Неверный hash для подтверждения.', 403);
        }

        if ($user->hasVerifiedEmail()) {
            return $this->sendResponse(['message' => 'Email уже подтвержден.'], '200');
        }
        // Подтвердить email
        $user->markEmailAsVerified();

        // Генерировать событие (опционально)
        event(new Verified($user));

        // Вернуть успешный ответ
        return redirect()->to(env('CLIENT_URL') . '/pages/authentication/verify-email-v1');
    }

    /**
     * Resent verificaiton email to user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return $this->sendResponse(['message' => 'На ваш адрес электронной почты отправлена новая ссылка для проверки.'], '200');
    }
}
