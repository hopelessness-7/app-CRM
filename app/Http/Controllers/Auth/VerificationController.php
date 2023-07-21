<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\MainController;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class VerificationController extends MainController
{
    public function verify($id, Request $request): RedirectResponse|JsonResponse
    {
        try {
            if (!$request->hasValidSignature()) {
                throw new \Exception('invalid/Expired url provided', 404);
            }

            $user = User::findOrFail($id);

            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
                event(new Verified($user));
            }

            $redirectUrl = '/';

            return Redirect::to($redirectUrl);
        } catch (Exception $e) {
            return $this->sendError(['error' => $e->getMessage()], $e->getCode() ?: 500);
        }

    }

    public function resend(Request $request): JsonResponse
    {
        try {
            if ($request->user()->hasVerifiedEmail()) {
                throw new \Exception('email already verified', 400);
            }

            $request->user()->sendEmailVerificationNotification();

            return $this->sendResponse([], '200');
        } catch (Exception $e) {
            return $this->sendError(['error' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
